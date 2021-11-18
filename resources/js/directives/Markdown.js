function activatePlugins(md, arg) {
    arg = arg || "default";
    switch (arg) {
        case 'min':
            break;
        default:
    }
}

function getModifiers(modifiers) {
    var options = {}

    if (modifiers.html) {
        options.html = true
    }

    if (modifiers.xhtmlOut) {
        options.xhtmlOut = true
    }

    if (modifiers.breaks) {
        options.breaks = true
    }

    if (modifiers.linkify) {
        options.linkify = true
    }

    if (modifiers.typographer) {
        options.typographer = true
    }

    // if (modifiers.commonmark) {
    //   options.commonmark = true
    // }

    return options
}

export default {

    beforeMount(el, binding, vnode) {

        var modifiers = getModifiers(binding.modifiers)

        // if (modifiers.commonmark) {
        //   var md = require('markdown-it')('commonmark')
        // } else {
        //   var md = require('markdown-it')(modifiers)
        // }

        var md = require('markdown-it')(modifiers)

        if (binding.arg) {
            var arg = binding.arg
        }

        activatePlugins(md, arg)
        el.innerHTML = md.render(el.innerHTML)
    }
}
