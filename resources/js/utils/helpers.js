/**
 * Get value of an object property/path even if it's nested
 */
export function getValueByPath(obj, path) {
    return path.split('.').reduce((o, i) => o ? o[i] : null, obj)
}


export function removeElement(el) {
    if (typeof el.remove !== 'undefined') {
        el.remove()
    } else if (typeof el.parentNode !== 'undefined' && el.parentNode !== null) {
        el.parentNode.removeChild(el)
    }
}


export function createAbsoluteElement(el) {
    const root = document.createElement('div')
    root.style.position = 'absolute'
    root.style.left = '0px'
    root.style.top = '0px'
    const wrapper = document.createElement('div')
    root.appendChild(wrapper)
    wrapper.appendChild(el)
    document.body.appendChild(root)
    return root
}

export function toCssWidth(width) {
    return width === undefined ? null : (isNaN(width) ? width : width + 'px')
}

export function isCustomElement(vm) {
    return 'shadowRoot' in vm.$root.$options
}



