const voprosImg1 = document.getElementById("vopros-img1");
const voprosPodskazka1 = document.getElementById("vopros-podskazka1");


voprosImg1.addEventListener("click", function() {
    voprosPodskazka1.style.display = "block";
    
    // Получаем координаты элемента на странице
    var rect = voprosImg1.getBoundingClientRect();

    // Задаем позицию подсказки над элементом
    voprosPodskazka1.style.top = rect.top - voprosPodskazka1.offsetHeight - 5 + 'px'; // 10 пикселей - это отступ между элементом и подсказкой
    voprosPodskazka1.style.left = rect.left - 215 + 'px'; // Смещаем на 10 пикселей левее;
});



document.addEventListener("click", function(event) {
    if (!event.target.closest(".vopros") && !event.target.closest(".vopros-podskazka")) {
        voprosPodskazka1.style.display = "none";
    }
});
document.addEventListener("DOMContentLoaded", function() {
    var minutes = 10;
    var seconds = 0;
    document.getElementById("timer").innerHTML = minutes + ":" + (seconds < 10 ? "0" : "") + seconds;
    
    var countdown = setInterval(function() {
      seconds--;
      if (seconds < 0) {
        seconds = 59;
        minutes--;
      }
      if (minutes < 0) {
        clearInterval(countdown);
        document.getElementById("timer").innerHTML = "Zkuste to znovu";
      } else {
        var time = "";
        if (minutes < 10) {
          time += "0";
        }
        time += minutes + ":";
        if (seconds < 10) {
          time += "0";
        }
        time += seconds;
        document.getElementById("timer").innerHTML = time;
      }
    }, 1000);
  });

