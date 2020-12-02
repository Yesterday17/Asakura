Element.prototype.css = function (key, value) {
    const setValue = (key, value) => {
        if ((key === "width" || key === "height") && typeof value === 'number') {
            value = `${value}px`;
        }
        this.style[key] = String(value);
    }

    if (typeof this.style === 'object') {
        if (arguments.length === 1 && typeof key === 'string') {
            return this.style[key];
        } else if (arguments.length === 1 && typeof key === 'object') {
            for (const k in key) {
                if (key.hasOwnProperty(k)) {
                    setValue(k, key[k]);
                }
            }
        } else {
            setValue(key, value);
        }
    }
}

function getFloat(sel, key) {
    const el = sel instanceof Element ? sel : document.querySelector(sel);
    return parseFloat(getComputedStyle(el, null)[key].replace(/px/, ''));
}

function resizeImage(id) {
    document.getElementById(id).css({
        'position': 'absolute',
        'top': '0px',
        'left': '0px',
        'width': '100%',
        'height': '100%',
        'z-index': -1,
        'overflow': 'hidden'
    });
    const w = getFloat(document.body, 'width');
    const h = getFloat(document.body, 'height');
    const o = document.getElementById(id).querySelector('img');
    const imageWidth = getFloat(o, 'width');
    const imageHeight = getFloat(o, 'height');
    o.css({
        'display': 'block',
        'opacity': 0
    });
    if (w > h) {
        if (imageWidth > imageHeight) {
            const newIh = Math.round((imageHeight / imageWidth) * w);
            o.css('width', w);
            o.css('height', newIh);
            if (newIh < h) {
                o.css('height', h);
                o.css('width', Math.round((imageWidth / imageHeight) * h))
            }
        } else {
            o.css('height', h);
            o.css('width', Math.round((imageWidth / imageHeight) * h))
        }
    } else {
        o.css('height', h);
        o.css('width', Math.round((imageWidth / imageHeight) * h))
    }
    const newIW = getFloat(o, 'width');
    const newIH = getFloat(o, 'height');
    if (newIW > w) {
        const l = (newIW - w) / 2;
        o.css('margin-left', -l)
    } else {
        o.css('margin-left', 0)
    }
    if (newIH > h) {
        const t = (newIH - h) / 2;
        o.css('margin-top', -t)
    } else {
        o.css('margin-top', 0)
    }
    o.css({
        'opacity': '1'
    })
}