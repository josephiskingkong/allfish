const voprosImg1 = document.getElementById("vopros-img1");
const voprosPodskazka1 = document.getElementById("vopros-podskazka1");

const voprosImg2 = document.getElementById("vopros-img2");
const voprosPodskazka2 = document.getElementById("vopros-podskazka2");

voprosImg1.addEventListener("click", function() {
    voprosPodskazka1.style.display = "block";
    
    // Получаем координаты элемента на странице
    var rect = voprosImg1.getBoundingClientRect();

    // Задаем позицию подсказки над элементом
    voprosPodskazka1.style.top = rect.top - voprosPodskazka1.offsetHeight - 5 + 'px'; // 10 пикселей - это отступ между элементом и подсказкой
    voprosPodskazka1.style.left = rect.left - 215 + 'px'; // Смещаем на 10 пикселей левее;
});

voprosImg2.addEventListener("click", function() {
    voprosPodskazka2.style.display = "block";

    // Получаем координаты элемента на странице
    var rect = voprosImg2.getBoundingClientRect();

    // Задаем позицию подсказки над элементом
    voprosPodskazka2.style.top = rect.top - voprosPodskazka2.offsetHeight - 5 + 'px'; // 10 пикселей - это отступ между элементом и подсказкой
    voprosPodskazka2.style.left = rect.left - 215 + 'px';
});

document.addEventListener("click", function(event) {
    if (!event.target.closest(".vopros") && !event.target.closest(".vopros-podskazka")) {
        voprosPodskazka1.style.display = "none";
    }
    
    if (!event.target.closest(".vopros2") && !event.target.closest(".vopros-podskazka")) {
        voprosPodskazka2.style.display = "none";
    }
});