document.addEventListener("DOMContentLoaded", () => {
  // ====================================================
  // Flat Swiper & Thumbs
  // ====================================================
  let flatSwiper = new Swiper(".flat-swiper", {
    spaceBetween: 10,
    slidesPerView: 3,
    watchSlidesProgress: true,
  });
  let flatSwiper2 = new Swiper(".flat-swiper2", {
    spaceBetween: 10,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    thumbs: {
      swiper: flatSwiper,
    },
  });

  // ====================================================
  // Pop Swiper & Thumbs with Breakpoints
  // ====================================================
  let popSwiper = new Swiper(".pop-swiper", {
    spaceBetween: 10,
    slidesPerView: 5,
    watchSlidesProgress: true,
    breakpoints: {
      320: { slidesPerView: 3, spaceBetween: 40 },
      640: { slidesPerView: 3, spaceBetween: 40 },
      768: { slidesPerView: 3, spaceBetween: 40 },
      1024: { slidesPerView: 5, spaceBetween: 10 },
    },
  });
  let popSwiper2 = new Swiper(".pop-swiper2", {
    spaceBetween: 10,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    thumbs: {
      swiper: popSwiper,
    },
  });

  // ====================================================
  // Date Swiper with Pagination and Breakpoints
  // ====================================================
  let dateSwiper = new Swiper(".date-swiper", {
    slidesPerView: 3,
    spaceBetween: 10,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    breakpoints: {
      640: { slidesPerView: 3, spaceBetween: 10 },
      768: { slidesPerView: 3, spaceBetween: 10 },
      1024: { slidesPerView: 3, spaceBetween: 10 },
    },
  });

  // ====================================================
  // Popup Toggle
  // ====================================================
  const togglePopup = document.getElementById("togglePopup");
  const popup = document.getElementById("popup");
  const closePopup = document.getElementById("closePopup");
  const overlay = document.getElementById("overlay");

  if (togglePopup && popup && closePopup && overlay) {
    togglePopup.addEventListener("click", () => {
      popup.style.display = "block";
      overlay.style.display = "block";
    });
    closePopup.addEventListener("click", () => {
      popup.style.display = "none";
      overlay.style.display = "none";
    });
    overlay.addEventListener("click", () => {
      popup.style.display = "none";
      overlay.style.display = "none";
    });
  }

  // ====================================================
  // Tabs for .flatTab elements
  // ====================================================
  const tabs = document.querySelectorAll(".flatTab");
  const contents = document.querySelectorAll(".flatTab-content");
  tabs.forEach((tab) => {
    tab.addEventListener("click", () => {
      tabs.forEach((t) => t.classList.remove("active"));
      contents.forEach((c) => c.classList.remove("active"));
      tab.classList.add("active");
      const target = document.getElementById(tab.dataset.tab);
      if (target) {
        target.classList.add("active");
      }
    });
  });

  // ====================================================
  // Swiper instances for elements with classes swiper1-in to swiper8-in
  // ====================================================
  const swiperSelectors = [
    ".swiper1-in",
    ".swiper2-in",
    ".swiper3-in",
    ".swiper4-in",
    ".swiper5-in",
    ".swiper6-in",
    ".swiper7-in",
    ".swiper8-in",
  ];
  swiperSelectors.forEach((selector) => {
    new Swiper(selector, {
      spaceBetween: 50,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
    });
  });

  // ====================================================
  // Main Properties Swiper (swiper3)
  // ====================================================
  new Swiper(".swiper3", {
    spaceBetween: 20,
    slidesPerView: 3,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    breakpoints: {
      320: { slidesPerView: 1, spaceBetween: 20 },
      640: { slidesPerView: 2, spaceBetween: 20 },
      768: { slidesPerView: 3, spaceBetween: 40 },
      1024: { slidesPerView: 3, spaceBetween: 20 },
    },
    preventClicks: true,
    preventClicksPropagation: true,
    hashNavigation: false,
  });
});
