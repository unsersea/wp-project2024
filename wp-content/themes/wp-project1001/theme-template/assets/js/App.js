const TEXTAREA_INIT = "textarea#";
const WIDTH_INIT = "100%";
const HEIGHT_INIT = "320"; // px
const LANGUAGE_VI = "vi";
const ELEMENT_FORMAT = "html";

var TODAY = new Date();
var DAY = String(TODAY.getDate()).padStart(2, "0");
var MONTH = String(TODAY.getMonth() + 1).padStart(2, "0");
var YEAR = TODAY.getFullYear();

var SWIPER;
const SwiperIDX01 = ".swiper-index-tt01";

(function () {
  SWIPER = function swipper() {
    var swiper = new Swiper(SwiperIDX01, {
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });
  };
})(jQuery);

SWIPER();
