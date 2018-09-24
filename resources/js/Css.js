/**
 * CSS Helper class.
 */
class Css {
    /**
     * Gets the :root element.
     */
    constructor () {
        this.el = document.documentElement;
    }

    /**
     * Updates a variable.
     *
     * @param {string} key
     * @param {string} val
     */
    set (key, val) {
        this.el.style.setProperty(`--${key}`, val);
    }

    /**
     * Gets a variable.
     *
     * @param {string} key
     */
    get (key) {
        return getComputedStyle(this.el).getPropertyValue(`--${key}`);
    }
}

export default Css;
