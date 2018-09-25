import tinycolor from 'tinycolor2';

import Css from './Css';

(() => {
    // Create CSS Helper
    const css = new Css();

    // Get the album color palette
    const { palette } = window;

    // Convert the colors to tinycolor instances
    const colors = palette.map(([r, g, b]) => tinycolor({ r, g, b}));

    // Determine which color to use for the background
    const newBackgroundColor = getNicest(colors);

    // Get the current text color (outside of the card)
    const currentTextColor = tinycolor(css.get('contrasting'));

    // If the text won't be readable, switch the text from black to white.
    if (!tinycolor.isReadable(newBackgroundColor, currentTextColor)) {
        css.set('contrasting', css.get('white'));
    }

    if (newBackgroundColor.isDark()) {
        css.set('shadow', tinycolor(css.get('white')).setAlpha(0.2).toRgbString());
    }

    // Determine which color to use as the complementary
    const complementary = getComplementary(newBackgroundColor);

    // Update the theme colors
    css.set('background', newBackgroundColor.toRgbString());
    css.set('complementary', complementary.toRgbString());
})();

/**
 * Gets the most saturated color from an array of colors.
 * Probably a better way to determine which color to use, but this seems to work ok.
 *
 * @param {TinyColor[]} colors
 * @returns {TinyColor}
 */
function getNicest (colors) {
    const sorted = colors.sort((a, b) => {
        const aSaturation = a.toHsl().s;
        const bSaturation = b.toHsl().s;

        return aSaturation < bSaturation;
    });

    return sorted[0];
}

/**
 * Determines the best color to use as the complementary.
 *
 * @param {TinyColor} color
 * @returns {TinyColor}
 */
function getComplementary (color) {
    const complementary = color.complement();

    return complementary.getBrightness() < 30
        ? complementary.brighten(50).saturate(50)
        : complementary;
}
