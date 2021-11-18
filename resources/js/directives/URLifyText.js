export default {
  beforeMount(el, binding, vnode) {
    function linkify(text) {
      var urlRegex = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
      return text.replace(urlRegex, function (url) {
        return '<a href="' + url + '">' + url + '</a>';
      });
    }
    el.innerHTML = linkify(el.innerHTML);
  },
}
