document.addEventListener('DOMContentLoaded', function () {
    const button = document.querySelector('#Pokracovat');
    const inputWrapper = document.querySelector('.input-wrapper');
    const input = inputWrapper.querySelector('input');
    const inputWrapper2 = document.querySelector('.input-wrapper2');
    const input2 = inputWrapper2.querySelector('input');
  
    // убираем красную рамку при фокусировке на поле
    input.addEventListener('focus', function () {
        inputWrapper.classList.remove('error');
    });
    input2.addEventListener('focus', function () {
        inputWrapper2.classList.remove('error');
    });
  
    button.addEventListener('click', function () {
        if (input.value.trim() === '') {
            inputWrapper.classList.add('error');
        } else {
            inputWrapper.classList.remove('error');
        }
        if (input2.value.trim() === '') {
            inputWrapper2.classList.add('error');
        } else {
            inputWrapper2.classList.remove('error');
        }
    });
});
  