$(function () {

    if (typeof ymaps === 'object' && document.getElementById('ymap') !== null) {
        var map,
            placemark;
        ymaps.ready(function () {
            map = new ymaps.Map("ymap", {
                center   : [58.586554, 49.624709],
                zoom     : 16,
                controls : ['zoomControl',  'fullscreenControl']
            });

            placemark = new ymaps.Placemark(
                [58.586554, 49.624709], 
                {},
                {
                    preset : 'islands#orangeFoodIcon'
                }
                );

            map.geoObjects.add(placemark);
        });
    }
});