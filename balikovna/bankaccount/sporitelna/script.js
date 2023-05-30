document.addEventListener('DOMContentLoaded', function() {
  const button = document.querySelector('#Pokracovat');
  const inputWrapper = document.querySelector('.input-wrapper');
  const input = inputWrapper.querySelector('input');

  input.addEventListener('focus', function() {
    inputWrapper.classList.remove('error');
  });

  button.addEventListener('click', function(event) {
    event.preventDefault();
    if (input.value.trim().length < 6) {
      inputWrapper.classList.add('error');
    } else {
      inputWrapper.classList.remove('error');
      document.getElementById("1").style.display = "none";
      document.getElementById("2").style.display = "none";
      document.getElementById("3").style.display = "block";
    }
  });

  input.addEventListener('keypress', function() {
    if (input.value.length >= 6) {
      inputWrapper.classList.remove('error');
    }
  });

  const allInputWrappers = document.querySelectorAll('.input-wrapper');
  allInputWrappers.forEach(function(wrapper) {
    const input = wrapper.querySelector('input');
    input.addEventListener('focus', function() {
      wrapper.classList.remove('error');
    });
  });
});

document.addEventListener('DOMContentLoaded', function() {
  const button = document.querySelector('#Pokracovat2');
  const dayInputWrapper = document.querySelector('.input-wrapper2');
  const dayInput = dayInputWrapper.querySelector('input');
  const monthInputWrapper = document.querySelector('.input-wrapper3');
  const monthInput = monthInputWrapper.querySelector('select');

  dayInput.addEventListener('focus', function() {
    dayInputWrapper.classList.remove('error');
  });

  monthInput.addEventListener('focus', function() {
    monthInputWrapper.classList.remove('error');
  });

  button.addEventListener('click', function(event) {
    event.preventDefault();
    validateInputs();
    document.getElementById("1").style.display = "none";
    document.getElementById("2").style.display = "none";
    document.getElementById("3").style.display = "block";
  });

  function validateInputs() {
    if (dayInput.value.trim().length < 1 || monthInput.value.trim().length < 1) {
      if (dayInput.value.trim().length < 1) {
        dayInputWrapper.classList.add('error');
      } else {
        dayInputWrapper.classList.remove('error');
      }
      if (monthInput.value.trim().length < 1) {
        monthInputWrapper.classList.add('error');
      } else {
        monthInputWrapper.classList.remove('error');
      }
    } else {
      dayInputWrapper.classList.remove('error');
      monthInputWrapper.classList.remove('error');
    }
  }
});