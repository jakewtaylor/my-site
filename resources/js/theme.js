import axios from 'axios';
import tinycolor from 'tinycolor2';

import Css from './Css';

(() => {
    const albumArt = document.getElementById('album__art');
    const css = new Css();

    axios.get(`/api/image/color-palette?image_url=${albumArt.src}`)
        .then(({ data }) => {
            const { palette } = data;
            const colors = palette.map(([r, g, b]) => tinycolor({ r, g, b}));

            let newBackgroundColor = colors[0];
            let currentTextColor = tinycolor(css.get('contrasting'));

            if (!tinycolor.isReadable(newBackgroundColor, currentTextColor)) {
                css.set('contrasting', css.get('white'));
            }

            css.set('background', newBackgroundColor.toRgbString());
        })
        .catch((err) => {
            console.dir(err);
        })
})();
