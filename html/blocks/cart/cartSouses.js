import Glide from '@glidejs/glide';

export default function mountSouses() {

    if (document.querySelector('.jsGlide') == null) return false;

    new Glide('.jsGlide', {
        type: 'carousel',
        startAt: 0,
        perView: 3
    }).mount();
}