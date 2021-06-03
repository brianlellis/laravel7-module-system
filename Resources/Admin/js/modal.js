if (!Rapyd.Modal) {
  (_self => {
    Rapyd.Modal = {
      props: {
        event_esc: false
      },

      init() {
        _self = this;
        _self.openRegistrationNav();
        _self.closeModal();
      },

      eventEscapeKeyDown(element) {
        document.addEventListener("keydown", e => {
          if (e.key == "Escape" || e.key == "Esc" || e.keyCode == 27) {
            e.preventDefault();
            element.classList.remove("active");
          }
        });
      },
      openRegistrationNav() {
        _self.scrollToggle(".modal-bottom", "active", 400);

        if (!document.getElementById("modal_open_button")) {
          return;
        }

        document
          .getElementById("modal_open_button")
          .addEventListener("click", () => {
            const ele = document.getElementById(
                "top_header-login-registration-wrap"
              ),
              ele_2 = document.getElementById("top_header-registration-form"),
              ele_3 = document.getElementById("top_header-signin-form"),
              ele_4 = document.getElementById("modal-bottom-contributor");

            ele.classList.add("active");
            ele_2.classList.add("active");
            ele_3.classList.remove("active");
            ele_4.classList.remove("active");
            ele_4.classList.add("closing");

            window.scroll({
              top: 0,
              left: 0,
              behavior: "smooth"
            });
          });
      },
      openModal(toggle, element) {
        document.querySelector(toggle).addEventListener("click", () => {
          const ele = document.querySelector(element);
          ele.classList.remove("closing");
          ele.classList.add("active");
        });
      },
      closeModal(target) {
        if (target) {
          return document.querySelector(target).classList.remove("active");
        }

        // Check If User Is Signed In
        if (!document.getElementById(`modal-bottom-contributor-close`)) {
          return;
        }

        const ele_close = document.getElementById(
            `modal-bottom-contributor-close`
          ),
          ele_window = document.getElementById("modal-bottom-contributor");

        if (!_self.props.event_esc) _self.eventEscapeKeyDown(ele_window);
        ele_close.addEventListener("click", () => {
          ele_window.classList.add("closing");
          ele_window.classList.remove("active");
        });
      },
      fadeIn(target, time) {
        const ele = document.querySelector(target);
        setTimeout(() => ele.classList.add("active"), time);
      },
      scrollToggle(target, applyClass, scrollY) {
        _self = this;
        window.addEventListener("scroll", () => {
          const element = document.querySelector(target);
          const pageHeight = document.documentElement.offsetHeight;
          const windowHeight = window.innerHeight;
          const scrollPosition =
            window.scrollY ||
            window.pageYOffset ||
            document.body.scrollTop +
              ((document.documentElement &&
                document.documentElement.scrollTop) ||
                0);

          const atBottom = pageHeight <= windowHeight + scrollPosition;

          if (!element || element.classList.contains("closing")) return;

          // If element is bottom modal get footer height
          const footerHeight = document.getElementById("site-footer")
            .offsetHeight;
          if (!atBottom && scrollPosition > scrollY) {
            element.classList.add(applyClass);
            element.style.bottom = 0;
          } else if (atBottom) {
            element.style.bottom = footerHeight + "px";
          }
        });
      }
    };
  })();
  Rapyd.Modal.init();
}