class Css {
    constructor () {
        this.el = document.documentElement;
        this.style = getComputedStyle(this.el);
    }

    set (key, val) {
        this.el.style.setProperty(`--${key}`, val);
    }

    get (key) {
        return this.style.getPropertyValue(`--${key}`);
    }
}

export default Css;
