$(() => {
    'use strict'

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').prop('content'),
        },
    })

    window.Theme = window.Theme || {}

    const isRTL = Theme.isRtl()

    window.Theme.isRtl = () => {
        return document.body.getAttribute('dir') === 'rtl'
    }

    const windowOn = $(window)

    document.addEventListener('shortcode.loaded', () => {
        initSwiper();
        initCounterUp();
    })

    const initSwiper = () => {
        initSwiperSlider('.box-lvhd-right', {
            slidesPerView: 2.5,
            spaceBetween: 30,
            navigation: {
                nextEl: ".lvhd-button-next",
                prevEl: ".lvhd-button-prev",
            },
            breakpoints: {
                320: {
                    slidesPerView: 1.2,
                    spaceBetween: 10,
                },
                767: {
                    slidesPerView: 1.5,
                    spaceBetween: 10,
                },
                991: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                1200: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
            },
        })

        initSwiperSlider('.home_sp_kkgd_wrapper', {
            slidesPerView: 4,
            navigation: {
                nextEl: ".home_sp_kkgd_wrapper .lvhd-button-next",
                prevEl: ".home_sp_kkgd_wrapper .lvhd-button-prev",
            },
            breakpoints: {
                320: {
                    slidesPerView: 1.5,
                    spaceBetween: 10,
                },
                767: {
                    slidesPerView: 2.7,
                    spaceBetween: 10,
                },
                991: {
                    slidesPerView: 4,
                    spaceBetween: 20,
                },
            },
        })

        initSwiperSlider('.list-equal-right', {
            slidesPerView: 5,
            spaceBetween: 30,
            breakpoints: {
                320: {
                    slidesPerView: 1.2,
                    spaceBetween: 10,
                },
                767: {
                    slidesPerView: 1.5,
                    spaceBetween: 10,
                },
                991: {
                    slidesPerView: 2.5,
                    spaceBetween: 20,
                },
                1400: {
                    slidesPerView: 5,
                    spaceBetween: 20,
                },
            },
        })

        initSwiperSlider('.list-slick-slider-brand-mafei', {
            slidesPerView: 4,
            navigation: {},
            breakpoints: {
                320: {
                    slidesPerView: 1.5,
                    spaceBetween: 10,
                },
                767: {
                    slidesPerView: 2.7,
                    spaceBetween: 10,
                },
                991: {
                    slidesPerView: 4,
                    spaceBetween: 20,
                },
            },
        })

        initSwiperSlider('.list-brand-slider', {
            slidesPerView: 3,
            spaceBetween: 30,
            grid: {
                rows: 2,
                fill: "row",
            },
            breakpoints: {
                320: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                767: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                991: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                1400: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
            },
        })

        initSwiperSlider('.news-slide-list', {
            direction: "vertical",
            slidesPerView: 3,
            spaceBetween: 30,
            breakpoints: {
                320: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                767: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                991: {
                    slidesPerView: 2.5,
                    spaceBetween: 20,
                },
                1400: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
            },
        })

        initSwiperSlider('.box-slider-custumer', {
            slidesPerView: 3,
            spaceBetween: 30,
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 0,
                },
                767: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                991: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                1400: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
            },
        })

        new Swiper(".banner-desk", {
            loop: true,
        });
    }

    // Initialize Swiper

    const initSwiperSlider = (element, options) => {
        const $element = $(element)

        if (!$element.length) {
            return
        }

        options = options || {}
        options.rtl = isRTL

        if ($element.data('autoplay')) {
            options.autoplay = {
                delay: $element.data('autoplay-speed') || 5000,
            }
        }

        if ($element.data('effect')) {
            options.effect = $element.data('effect')
        }

        if ($element.data('loop')) {
            options.loop = $element.data('loop')
        }

        if ($element.data('items')) {
            options.slidesPerView = $element.data('items')
        }



        new Swiper(element, options)
    }


    const initCounterUp = () => {
        // Kiểm tra nếu đã chạy
        if (window.counterScriptExecuted) {
            console.log('Counter already executed – skipping');
            return;
        }

        const $counters = $('.counter');

        // Không có phần tử nào
        if ($counters.length === 0) {
            console.log('No .counter elements found – skipping');
            return;
        }

        console.log('Running counterUp immediately');

        // Gọi counterUp ngay lập tức, không dùng dấu phẩy
        $counters.each(function () {
            const $this = $(this);

            $this.prop('Counter', 0).animate({
                Counter: parseInt($this.text().replace(/,/g, '')) || 0
            }, {
                duration: 1200,
                easing: 'swing',
                step: function (now) {
                    $this.text(Math.ceil(now)); // 👈 KHÔNG format
                }
            });
        });

        // Đánh dấu đã chạy
        window.counterScriptExecuted = true;
    };


    // Mobile menu toggle
    $(".mobile-menu-btn").on("click", function () {
        $(".menu").toggleClass("active");
    });

    // Tabs switching
    $(".nav-tabs .nav-item").on("click", function () {
        $(".nav-tabs .nav-item").removeClass("active");
        $(".tab-pane").removeClass("active");

        $(this).addClass("active");
        const targetId = $(this).data("electronic");
        $("#" + targetId).addClass("active");
    });

    // Submenu toggle
    $(".menu .has-submenu > a").on("click", function (e) {
        // e.preventDefault();

        const $parent = $(this).parent();

        $(".menu .has-submenu").not($parent).removeClass("open");
        $parent.toggleClass("open");
    });
});

document.addEventListener("DOMContentLoaded", function () {
  const content = document.querySelector(".ps-block__content");
  const tocContainer = content.querySelector("#table-of-contents");

  // Lấy tất cả h2 nhưng không lấy h2 nằm trong #table-of-contents
  const headings = Array.from(content.querySelectorAll("h2")).filter(h2 => !tocContainer.contains(h2));

  const ul = document.createElement("ul");

  headings.forEach((heading, index) => {
    // Gán id nếu chưa có
    if (!heading.id) {
      heading.id = `section-${index + 1}`;
    }

    const li = document.createElement("li");
    const a = document.createElement("a");
    a.href = `#${heading.id}`;
    a.textContent = heading.textContent;

    li.appendChild(a);
    ul.appendChild(li);
  });

  tocContainer.appendChild(ul);
});