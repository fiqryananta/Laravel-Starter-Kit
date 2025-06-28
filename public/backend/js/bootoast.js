(function (global) {
    var Bootoast = function (options) {
        return new Bootoast.init(options);
    };

    Bootoast.init = function (options) {
        var self = this;

        self.settings = extend({
            message: null,
            type: "info",
            position: "bottom-center",
            icon: null,
            timeout: null,
            animationDuration: 300,
            dismissible: true
        }, options || {});

        self.container = document.createElement("div");
        self.container.className = "bootoast";
        self.container.classList.add("bootoast-" + self.settings.type);
        self.container.classList.add("bootoast-position-" + self.settings.position);

        if (self.settings.dismissible) {
            var closeBtn = document.createElement("button");
            closeBtn.className = "bootoast-close";
            closeBtn.innerHTML = "&times;";
            closeBtn.onclick = function () {
                self.dismiss();
            };
            self.container.appendChild(closeBtn);
        }

        if (self.settings.icon) {
            var icon = document.createElement("span");
            icon.className = "bootoast-icon " + self.settings.icon;
            self.container.appendChild(icon);
        }

        var message = document.createElement("span");
        message.className = "bootoast-message";
        message.innerHTML = self.settings.message;
        self.container.appendChild(message);

        document.body.appendChild(self.container);

        // Auto-dismiss after timeout
        if (self.settings.timeout) {
            setTimeout(function () {
                self.dismiss();
            }, self.settings.timeout);
        }
    };

    Bootoast.init.prototype.dismiss = function () {
        var self = this;
        if (!self.container) return;

        self.container.classList.add("bootoast-fadeout");

        setTimeout(function () {
            if (self.container && self.container.parentNode) {
                self.container.parentNode.removeChild(self.container);
            }
        }, self.settings.animationDuration);
    };

    // Simple extend/merge function
    function extend(defaults, options) {
        for (var key in options) {
            if (options.hasOwnProperty(key)) {
                defaults[key] = options[key];
            }
        }
        return defaults;
    }

    // Export globally
    global.Bootoast = Bootoast;

})(window);
