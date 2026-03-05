<!-- SOUND_HOOK_OK -->
<style>
    #ordersSoundWidget {
        position: fixed;
        right: 16px;
        bottom: 16px;
        z-index: 2147483647;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 14px;
        background: rgba(15, 23, 42, 0.85);
        color: #fff;
        font: 700 13px/1.2 system-ui, -apple-system, Segoe UI, Roboto, Arial;
        backdrop-filter: blur(10px);
        box-shadow: 0 10px 30px rgba(0,0,0,.25);
        user-select: none;
    }
    #ordersSoundWidget button {
        border: 0;
        border-radius: 12px;
        padding: 8px 10px;
        cursor: pointer;
        font-weight: 900;
    }
    .btn-on { background: #16a34a; color: #fff; }
    .btn-off { background: #334155; color: #fff; }
    #ordersSoundHint {
        font-weight: 600;
        opacity: 0.85;
        font-size: 12px;
    }
</style>

<script>
(function () {
    function isOrdersIndexNow() {
        var path = String(window.location.pathname || '');
        return path.indexOf('/admin/orders') === 0 &&
            path.indexOf('/create') === -1 &&
            path.indexOf('/edit') === -1;
    }

    var ENDPOINT = '/admin/orders/latest';

    var KEY_LAST = 'orders_last_seen_id';
    var KEY_ENABLED = 'orders_sound_enabled';
    var KEY_FLASH_ID = 'orders_flash_id';

    var audio = new Audio('/sounds/new-order.mp3');
    audio.preload = 'auto';

    function enabled() {
        return localStorage.getItem(KEY_ENABLED) === '1';
    }

    function setEnabled(v) {
        localStorage.setItem(KEY_ENABLED, v ? '1' : '0');
        renderWidget();
    }

    async function unlockAudio() {
        try {
            audio.currentTime = 0;
            var p = audio.play();
            if (p && typeof p.then === 'function') await p;
            audio.pause();
            audio.currentTime = 0;
            return true;
        } catch (e) {
            return false;
        }
    }

    function playSound() {
        try {
            audio.currentTime = 0;
            var p = audio.play();
            if (p && typeof p.catch === 'function') p.catch(function(){});
        } catch (e) {}
    }

    function toast(html) {
        var t = document.createElement('div');
        t.innerHTML = html;
        t.style.cssText =
            'position:fixed;bottom:72px;right:16px;z-index:2147483647;' +
            'background:rgba(15,23,42,.94);color:#fff;padding:12px 14px;border-radius:14px;' +
            'box-shadow:0 10px 30px rgba(0,0,0,.25);max-width:360px;' +
            'font:600 13px/1.35 system-ui,-apple-system,Segoe UI,Roboto,Arial;';
        document.body.appendChild(t);

        setTimeout(function () {
            t.style.opacity = '0';
            t.style.transition = 'opacity .25s';
        }, 4500);

        setTimeout(function () { t.remove(); }, 4800);
    }

    function flashRow(orderId) {
        if (!orderId) return;

        localStorage.setItem(KEY_FLASH_ID, String(orderId));

        // Частый wire:key у строк Filament: table.records.<id>
        var candidates = document.querySelectorAll('[wire\\:key]');
        for (var i = 0; i < candidates.length; i++) {
            var k = candidates[i].getAttribute('wire:key') || '';
            if (k.indexOf('table.records.' + orderId) !== -1) {
                var row = candidates[i];
                row.style.transition = 'box-shadow .2s, transform .2s';
                row.style.boxShadow = '0 0 0 3px rgba(251, 191, 36, .65)';
                row.style.transform = 'scale(1.005)';

                setTimeout(function () {
                    row.style.boxShadow = '';
                    row.style.transform = '';
                }, 2000);

                return;
            }
        }
    }

    function renderWidget() {
        if (!isOrdersIndexNow()) {
            var old = document.getElementById('ordersSoundWidget');
            if (old) old.remove();
            return;
        }

        var el = document.getElementById('ordersSoundWidget');
        if (!el) {
            el = document.createElement('div');
            el.id = 'ordersSoundWidget';
            document.body.appendChild(el);
        }

        var isOn = enabled();

        el.innerHTML = `
            <span>🔔 Новые заказы</span>
            <button id="ordersSoundBtn" class="${isOn ? 'btn-on' : 'btn-off'}">
                🔊 ${isOn ? 'Звук: ВКЛ' : 'Звук: ВЫКЛ'}
            </button>
            <span id="ordersSoundHint">${isOn ? '' : 'Нажми чтобы включить'}</span>
        `;

        el.querySelector('#ordersSoundBtn').onclick = async function () {
            var next = !enabled();
            if (next) {
                var ok = await unlockAudio();
                setEnabled(true);
                if (!ok) {
                    var hint = document.getElementById('ordersSoundHint');
                    if (hint) hint.textContent = 'Браузер блокирует звук — кликни ещё раз';
                    return;
                }
                playSound();
            } else {
                setEnabled(false);
            }
        };
    }

    async function fetchLatest() {
        try {
            var res = await fetch(ENDPOINT, {
                method: 'GET',
                headers: { 'Accept': 'application/json' },
                credentials: 'same-origin',
                cache: 'no-store',
            });

            if (!res.ok) return null;

            return await res.json().catch(function(){ return null; });
        } catch (e) {
            return null;
        }
    }

    async function tick() {
        if (!isOrdersIndexNow()) return;

        // пробуем подсветить сохранённый id (на случай перерендера таблицы)
        var flashId = Number(localStorage.getItem(KEY_FLASH_ID) || 0);
        if (flashId) {
            flashRow(flashId);
            setTimeout(function () {
                if (Number(localStorage.getItem(KEY_FLASH_ID) || 0) === flashId) {
                    localStorage.removeItem(KEY_FLASH_ID);
                }
            }, 10000);
        }

        var data = await fetchLatest();
        if (!data || !data.id) return;

        var latestId = Number(data.id || 0);
        var lastSeen = Number(localStorage.getItem(KEY_LAST) || 0);

        // первый запуск — запоминаем без шума
        if (!lastSeen) {
            localStorage.setItem(KEY_LAST, String(latestId));
            return;
        }

        if (latestId > lastSeen) {
            localStorage.setItem(KEY_LAST, String(latestId));

            var pid = data.public_id ? String(data.public_id) : String(latestId);
            var phone = data.phone ? String(data.phone) : '';
            var total = (typeof data.total !== 'undefined' && data.total !== null) ? String(data.total) : '';

            var url = '/admin/orders/' + latestId + '/edit';

            toast(
                `<div style="font-weight:900;margin-bottom:6px;">🆕 Новый заказ #${pid}</div>` +
                (phone ? `<div style="opacity:.92;margin-bottom:2px;">📞 ${phone}</div>` : '') +
                (total ? `<div style="opacity:.92;margin-bottom:10px;">💰 Сумма: ${total}</div>` : '') +
                `<a href="${url}" style="display:inline-block;background:#2563eb;color:#fff;padding:8px 10px;border-radius:10px;text-decoration:none;font-weight:900;">Открыть заказ</a>`
            );

            flashRow(latestId);

            if (enabled()) {
                playSound();
            }
        }
    }

    function initOrRefresh() {
        renderWidget();
        tick();
    }

    // init
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initOrRefresh);
    } else {
        initOrRefresh();
    }

    // Filament SPA navigation
    document.addEventListener('livewire:navigated', initOrRefresh);
    document.addEventListener('livewire:load', initOrRefresh);

    setInterval(tick, 5000);
})();
</script>
