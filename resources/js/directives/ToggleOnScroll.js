
import debounce from '../functions/debounce'
import { isAbove } from '../functions/breakpoints'

export default {
  beforeMount(el, binding, vnode) {
    /* The following code is only responsible for making the nav go up and down based on scroll direction */
    const supportPageOffset = window.pageXOffset !== undefined;
    const isCSS1Compat = (document.compatMode || "") === "CSS1Compat";

    let previousScrollPosition = 0;

    const isScrollingDown = () => {
      // Get the current scroll position, a few checks to support IE if 100% needed.... -_-
      let scrolledPosition = supportPageOffset
        ? window.pageYOffset
        : isCSS1Compat
          ? document.documentElement.scrollTop
          : document.body.scrollTop;
      let isScrollDown;

      // Check if the current position is greater than the last known position
      if (scrolledPosition > (previousScrollPosition + 10)) {
        isScrollDown = true;
      } else {
        isScrollDown = false;
      }

      // Set current position as the new last known position
      previousScrollPosition = scrolledPosition;
      return isScrollDown;
    };

    const toggleScrollClasses = (bool) => {
      if (bool) {
        el.classList.add("scroll-down");
        el.classList.remove("scroll-up");
      } else {
        el.classList.add("scroll-up");
        el.classList.remove("scroll-down");
      }
    }

    el.handleNavScroll = function () {
      // Make sure we are at least past the height of header before doing anything
      if (window.scrollY > el.clientHeight) {
        if (isScrollingDown() && !isAbove.lg.matches) {
          toggleScrollClasses(true)
        } else {
          toggleScrollClasses(false)
        }
      } else {
        // Show header, we are below height
        toggleScrollClasses(false)
      }
    };

    // Accessibility check, some people don't like shit moving around
    const reducedMotionCheck = window.matchMedia("(prefers-reduced-motion: reduce)");

    if (reducedMotionCheck && !reducedMotionCheck.matches) {
      window.addEventListener("scroll", debounce(el.handleNavScroll, 100), true);
    }
  },
  unmounted(el) {
    window.removeEventListener("scroll", debounce(el.handleNavScroll, 100), true);
  }
}
