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
        initSlick()
    })

    $(document).on('click', '.related-product-pagination .pages-number', function (e) {
        e.preventDefault();

        const $element = $(this);
        const url = $element.attr('href');

        const $container = $element.closest('.tp-related-product');

        $.ajax({
            url: url,
            type: 'GET',
            success: ({ data }) => {
                $container.replaceWith(data); // ✅ Thay toàn bộ block cha bằng data

                // Cập nhật lazy load nếu có
                if (typeof Theme.lazyLoadInstance !== 'undefined') {
                    Theme.lazyLoadInstance.update();
                }

                // Khởi động lại Swiper nếu cần
                if (typeof initSwiper === 'function') {
                    initSwiper();
                }
            },
            error: (error) => Theme.handleError(error),
        });
    });

    $(document).on('click', '.related-post-pagination .pages-number', function (e) {
        e.preventDefault();

        const $element = $(this);
        const url = $element.attr('href');

        const $container = $element.closest('.tp-blog-area');

        $.ajax({
            url: url,
            type: 'GET',
            success: ({ data }) => {
                $container.replaceWith(data); // ✅ Thay toàn bộ block cha bằng data

                // Cập nhật lazy load nếu có
                if (typeof Theme.lazyLoadInstance !== 'undefined') {
                    Theme.lazyLoadInstance.update();
                }

                // Khởi động lại Swiper nếu cần
                if (typeof initSwiper === 'function') {
                    initSwiper();
                }
            },
            error: (error) => Theme.handleError(error),
        });
    });

    const initSlick = () => {
        $('.slick-wrapper-single-client-card').slick({
            dots: false,
            arrows: false,
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            responsive: [
                {
                    breakpoint: 551,
                    settings: {
                        slidesToShow: 1,
                        dots: false,
                        autoplay: true,
                        autoplaySpeed: 2000
                    }
                }
            ]
        });



        $('.slick-camnhankh').slick({
            dots: false,
            arrows: false,
            slidesToShow: 2,
            slidesToScroll: 1,
            autoplay: false,
            autoplaySpeed: 3000,
            responsive: [
                {
                    breakpoint: 551,
                    settings: {
                        slidesToShow: 1,
                        dots: false,
                        autoplay: true,
                        autoplaySpeed: 2000
                    }
                }
            ]
        });

        $('.slider-products-details').slick({
            dots: false,
            arrows: false,
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            responsive: [
                {
                    breakpoint: 551,
                    settings: {
                        slidesToShow: 1,
                        dots: false,
                        autoplay: true,
                        autoplaySpeed: 2000
                    }
                }
            ]
        });
    }


    const initSwiper = () => {
        $('.tp-product-related-slider-active').each(function (index, element) {
            const itemsPerView = $(element).data('items-per-view') || 4

            initSwiperSlider(element, {
                slidesPerView: itemsPerView,
                spaceBetween: 24,
                loop: false,
                enteredSlides: false,
                pagination: {
                    el: '.tp-related-slider-dot',
                    clickable: true,
                    renderBullet: function (index, className) {
                        return '<span class="' + className + '">' + '<button>' + (index + 1) + '</button>' + '</span>'
                    },
                },
                // Navigation arrows
                navigation: {
                    nextEl: '.tp-related-slider-button-next',
                    prevEl: '.tp-related-slider-button-prev',
                },

                scrollbar: {
                    el: '.tp-related-swiper-scrollbar',
                    draggable: true,
                    dragClass: 'tp-swiper-scrollbar-drag',
                    snapOnRelease: true,
                },

                breakpoints: {
                    1200: {
                        slidesPerView: itemsPerView,
                    },
                    992: {
                        slidesPerView: itemsPerView - 1,
                    },
                    768: {
                        slidesPerView: 2,
                    },
                    576: {
                        slidesPerView: 2,
                    },
                    0: {
                        slidesPerView: 2,
                        spaceBetween: 10,
                    },
                },
            })
        })

        $('.tp-blog-main-slider-active-2').each(function (index, element) {
            const $element = $(element)
            const itemsPerView = $element.data('items-per-view') || 4
            const slideCount = $element.find('.swiper-slide').length
            const shouldLoop = slideCount > itemsPerView

            initSwiperSlider(element, {
                slidesPerView: itemsPerView,
                spaceBetween: 24,
                loop: shouldLoop,
                enteredSlides: true,
                autoplay: false,
                allowTouchMove: shouldLoop,
                pagination: {
                    el: '.tp-related-slider-dot',
                    clickable: true,
                    renderBullet: function (index, className) {
                        return '<span class="' + className + '">' + '<button>' + (index + 1) + '</button>' + '</span>'
                    },
                },
                scrollbar: {
                    el: '.tp-post-related-swiper-scrollbar',
                    draggable: true,
                    dragClass: 'tp-swiper-scrollbar-drag',
                    snapOnRelease: true,
                },
                breakpoints: {
                    1200: {
                        slidesPerView: 4,
                    },
                    992: {
                        slidesPerView: 3,
                    },
                    768: {
                        slidesPerView: 2,
                    },
                    576: {
                        slidesPerView: 2,
                    },
                    0: {
                        slidesPerView: 2,
                        spaceBetween: 10,
                    },
                },
            })
        })



        initSwiperSlider('.box-lvhd-right', {
            slidesPerView: 2.5,
            spaceBetween: 30,
            autoplay: true,
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
            autoplay: true,
            navigation: {
                nextEl: ".home_sp_kkgd_wrapper .lvhd-button-next",
                prevEl: ".home_sp_kkgd_wrapper .lvhd-button-prev",
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 10,
                },
                767: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                991: {
                    slidesPerView: 4,
                    spaceBetween: 20,
                },
            },
        })

        // initSwiperSlider('.list-equal-right', {
        //     slidesPerView: 5,
        //     spaceBetween: 30,
        //     breakpoints: {
        //         320: {
        //             slidesPerView: 1.2,
        //             spaceBetween: 10,
        //         },
        //         767: {
        //             slidesPerView: 1.5,
        //             spaceBetween: 10,
        //         },
        //         991: {
        //             slidesPerView: 2.5,
        //             spaceBetween: 20,
        //         },
        //         1400: {
        //             slidesPerView: 5,
        //             spaceBetween: 20,
        //         },
        //     },
        // })

        initSwiperSlider('.list-slick-slider-brand-mafei', {
            slidesPerView: 5,
            navigation: {},
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 10,
                },
                767: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                991: {
                    slidesPerView: 5,
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
            slidesPerView: 4,
            spaceBetween: 30,
            watchOverflow: true,
            resistanceRatio: 0,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            breakpoints: {
                320: {
                    slidesPerView: 4,
                    spaceBetween: 10,
                },
                767: {
                    slidesPerView: 4,
                    spaceBetween: 10,
                },
                991: {
                    slidesPerView: 4,
                    spaceBetween: 20,
                },
                1400: {
                    slidesPerView: 4,
                    spaceBetween: 20,
                },
            },
        });

        initSwiperSlider('.list-address-slider', {
            slidesPerView: 3,
            spaceBetween: 30,
            breakpoints: {
                320: {
                    slidesPerView: 3,
                    spaceBetween: 0,
                },
                767: {
                    slidesPerView: 3,
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





        initSwiperSlider('.tp-slider-active-9', {
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            slidesPerView: 3,
            effect: 'fade',
            breakpoints: {
                320: {
                    slidesPerView: 2,
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


    initSwiperSlider('.box-slider-custumer-giayphep', {
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        slidesPerView: 3,
        spaceBetween: 30,
        breakpoints: {
            320: {
                slidesPerView: 1,
            },
            767: {
                slidesPerView: 2,
            },
            991: {
                slidesPerView: 3,
            },
            1400: {
                slidesPerView: 3,
            },
        },
    })


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
    if (!content) return;

    const tocContainer = content.querySelector("#table-of-contents");
    if (!tocContainer) return;

    // Lấy tất cả các thẻ h2 trong content, bỏ qua các h2 nằm trong TOC
    const headings = Array.from(content.querySelectorAll("h2")).filter(h2 => !tocContainer.contains(h2));
    if (headings.length === 0) return;

    const ul = document.createElement("ul");
    ul.classList.add("toc-list"); // Optional: thêm class nếu cần style

    headings.forEach((heading, index) => {
        // Gán id nếu chưa có để làm anchor
        if (!heading.id) {
            heading.id = `section-${index + 1}`;
        }

        const li = document.createElement("li");
        li.classList.add("toc-item"); // Optional: thêm class nếu cần style

        const a = document.createElement("a");
        a.href = `#${heading.id}`;
        a.textContent = heading.textContent.trim();
        a.classList.add("toc-link"); // Optional: thêm class nếu cần style

        li.appendChild(a);
        ul.appendChild(li);
    });

    // Xoá TOC cũ (nếu có) trước khi thêm mới
    tocContainer.innerHTML = '';
    tocContainer.appendChild(ul);
});


// Smooth scrolling
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Fade in animation on scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function (entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, observerOptions);

document.querySelectorAll('.fade-in').forEach(el => {
    observer.observe(el);
});



// Counter animation
function animateCounter(element, target, duration = 2000) {
    let start = 0;
    const increment = target / (duration / 16);

    const timer = setInterval(() => {
        start += increment;
        if (start >= target) {
            element.textContent = target + (element.textContent.includes('%') ? '%' : '+');
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(start) + (element.textContent.includes('%') ? '%' : '+');
        }
    }, 16);
}

// Trigger counter animation when stats section is visible
const statsObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const numbers = entry.target.querySelectorAll('.stat-number');
            numbers.forEach(num => {
                const target = parseInt(num.textContent);
                animateCounter(num, target);
            });
            statsObserver.unobserve(entry.target);
        }
    });
});

const statsSection = document.querySelector('.stats');
if (statsSection) {
    statsObserver.observe(statsSection);
}




// FAQ Toggle
document.querySelectorAll('.faq-question').forEach(question => {
    question.addEventListener('click', () => {
        const faqItem = question.parentElement;
        const isActive = faqItem.classList.contains('active');

        // Close all FAQ items
        document.querySelectorAll('.faq-item').forEach(item => {
            item.classList.remove('active');
        });

        // Open clicked item if it wasn't active
        if (!isActive) {
            faqItem.classList.add('active');
        }
    });
});



document.querySelectorAll('.scroll-animate').forEach(el => {
    observer.observe(el);
});



// Add floating animation to feature cards
document.querySelectorAll('.feature-card').forEach((card, index) => {
    card.style.animationDelay = `${index * 0.1}s`;
    card.addEventListener('mouseenter', () => {
        card.style.transform = 'translateY(-10px) scale(1.02) rotateY(5deg)';
    });
    card.addEventListener('mouseleave', () => {
        card.style.transform = 'translateY(0) scale(1) rotateY(0deg)';
    });
});

// Add typing effect to subtitle
let subtitle = document.querySelector('.subtitle');

if (subtitle) {
    const text = subtitle.textContent;

    subtitle.textContent = '';
    let i = 0;

    setTimeout(() => {
        const typeWriter = setInterval(() => {
            if (i < text.length) {
                subtitle.textContent += text.charAt(i);
                i++;
            } else {
                clearInterval(typeWriter);
            }
        }, 50);
    }, 1000);
}

// Add click ripple effect
function createRipple(event) {
    const button = event.currentTarget;
    const circle = document.createElement('span');
    const diameter = Math.max(button.clientWidth, button.clientHeight);
    const radius = diameter / 2;

    circle.style.width = circle.style.height = `${diameter}px`;
    circle.style.left = `${event.clientX - button.offsetLeft - radius}px`;
    circle.style.top = `${event.clientY - button.offsetTop - radius}px`;
    circle.classList.add('ripple');

    const ripple = button.getElementsByClassName('ripple')[0];
    if (ripple) {
        ripple.remove();
    }

    button.appendChild(circle);
}

// Add ripple effect styles
const rippleStyle = document.createElement('style');
rippleStyle.textContent = `
            .ripple {
                position: absolute;
                border-radius: 50%;
                background-color: rgba(255, 255, 255, 0.6);
                transform: scale(0);
                animation: ripple-animation 0.6s linear;
                pointer-events: none;
            }

            @keyframes ripple-animation {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
document.head.appendChild(rippleStyle);

// Apply ripple effect to buttons
document.querySelectorAll('.nav-item, .faq-question').forEach(item => {
    item.style.position = 'relative';
    item.style.overflow = 'hidden';
    item.addEventListener('click', createRipple);
});
function toggleFAQ(element) {
    const answer = element.nextElementSibling;
    const icon = element.querySelector('.icon');

    // Close all other FAQs
    document.querySelectorAll('.faq-answer.active').forEach(item => {
        if (item !== answer) {
            item.classList.remove('active');
            item.previousElementSibling.classList.remove('active');
        }
    });

    // Toggle current FAQ
    answer.classList.toggle('active');
    element.classList.toggle('active');
}

// Add smooth scrolling animation on load
window.addEventListener('load', function () {
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach((item, index) => {
        setTimeout(() => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.transition = 'all 0.5s ease';

            setTimeout(() => {
                item.style.opacity = '1';
                item.style.transform = 'translateY(0)';
            }, 100);
        }, index * 100);
    });
});


// FAQ Toggle Function
function toggleFAQ(element) {
    const answer = element.nextElementSibling;
    const isActive = answer.classList.contains('active');

    // Close all other FAQs
    document.querySelectorAll('.faq-answer.active').forEach(item => {
        item.classList.remove('active');
    });
    document.querySelectorAll('.faq-question.active').forEach(item => {
        item.classList.remove('active');
    });

    // Toggle current FAQ
    if (!isActive) {
        answer.classList.add('active');
        element.classList.add('active');
    }
}
document.querySelectorAll('.has-submenu > a').forEach(function (link) {
    link.addEventListener('click', function (e) {
        const parentLi = this.parentElement;
        const hasSub = parentLi.querySelector('.submenu');

        // Ngăn chuyển trang nếu có submenu
        if (hasSub) {
            e.preventDefault();

            // Lấy tất cả li cùng cấp
            const siblings = Array.from(parentLi.parentElement.children).filter(function (child) {
                return child.classList.contains('has-submenu') && child !== parentLi;
            });

            // Đóng các menu cùng cấp
            siblings.forEach(function (sibling) {
                sibling.classList.remove('active');
            });

            // Toggle menu hiện tại
            parentLi.classList.toggle('active');
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    function initEqualSlider() {
        if (window.innerWidth < 990) {
            if (!$('.list-equal-right').hasClass('slick-initialized')) {
                $('.list-equal-right').slick({
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    arrows: false,
                    dots: false,
                    autoplay: true,
                    autoplaySpeed: 3000,
                });
            }
        } else {
            if ($('.list-equal-right').hasClass('slick-initialized')) {
                $('.list-equal-right').slick('unslick');
            }
        }
    }

    // Khởi tạo khi load trang
    initEqualSlider();

    // Khởi tạo lại khi thay đổi kích thước trình duyệt
    window.addEventListener('resize', function () {
        initEqualSlider();
    });
});
