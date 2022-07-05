(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

})( jQuery );

window.addEventListener('load', albamnSlider);

function albamnSlider() {
  let groups = document.getElementsByClassName("albamn-slider-group");

  for (let i = 0, len = groups.length; i < len; i++) {
    albamnSliderAnimation(groups[i], 0);
  }
}

function albamnSliderAnimation(el, n) {
  let items = el.getElementsByClassName("albamn-slider-item");

  if (n === items.length) {
    n = 0;
  }

  // Remove
  if (n === 0) {
    items[items.length - 1].classList.remove("albamn-slider-show");
  } else {
    items[n - 1].classList.remove("albamn-slider-show");
  }

  // Add
  items[n].classList.add("albamn-slider-show");

  // Repeat
  setTimeout(function () {
    albamnSliderAnimation(el, n + 1)
  }, 9000);
}
