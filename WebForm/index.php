<style>
    body {
        font-size: large;
    }

    input, select, button {
        font-size: medium;
    }

    a {
        font-size: larger;
    }
</style>

<div id="parent">
<form id="requestForm">
    <input type="radio" id="fast" name="deliveryType" value="fast" checked>
    <label for="fast">Быстрая доставка</label>
    <input type="radio" id="slow" name="deliveryType" value="slow">
    <label for="slow">Медленная доставка</label>
    <br/><br/>
    <text>Отправление 1</text>
    <input name="sourceKladr[1]" type="text" placeholder="Начальный кладр" style="width:300px;" required/>
    <input name="targetKladr[1]" type="text" placeholder="Конечный кладр" style="width:300px;" required/>
    <input name="weight[1]" type="number" placeholder="Вес груза" style="width:300px;" required/>
    <select size="1" name="companyApi[1]" style="width:150px;">
      <option value="all">Все компании</option>
      <option value="pekApi">ПЭК</option>
      <option value="deloviyeLiniiApi">Деловые линии</option>
    </select>
    <a style="color:green;" onclick="return addField()" href="#">[+]</a>
    <button type="submit">Получить цены</button>
</form>
</div>

<script>
var countOfFields = 1; // Текущее число полей
var curFieldNameId = 1; // Уникальное значение для атрибута name
var maxFieldLimit = 25; // Максимальное число возможных полей

function addField() {
    if (countOfFields >= maxFieldLimit) {
        alert("Число полей достигло своего максимума = " + maxFieldLimit);
        return false;
    }
    countOfFields++;
    curFieldNameId++;

    const div = document.createElement("div");
    div.innerHTML = `<text>Отправление ${curFieldNameId} </text><input name="sourceKladr[${curFieldNameId}]" placeholder="Начальный кладр" type="text" style="width:300px;" required/> <input name="targetKladr[${curFieldNameId}]" type="text" placeholder="Конечный кладр" style="width:300px;" required/> <input name="weight[${curFieldNameId}]" type="number" placeholder="Вес груза" style="width:300px;" required/> <select size="1" name="companyApi[${curFieldNameId}]" style="width:150px;"><option value="all">Все компании</option> <option value="pekApi">ПЭК</option><option value="delovyeLiniiApi">Деловые линии</option></select> <a style="color:green;" onclick="return addField()" href="#">[+]</a>`;
    document.getElementById("requestForm").appendChild(div);

    return false;
}


const form = document.getElementById('requestForm');
form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const responseForm = document.getElementById('responseForm');
    if (responseForm !== null) {
        responseForm.remove();
    }

    let jsonObject = [];
    const formData = new FormData(form);

    for (let i = 1; formData.get(`sourceKladr[${i}]`) !== null; i++) {
        jsonObject.push({
            "departureNumber": `Отправление ${i}`,
            "sourceKladr": formData.get(`sourceKladr[${i}]`),
            "targetKladr": formData.get(`targetKladr[${i}]`),
            "weight": formData.get(`weight[${i}]`),
            "apiName": formData.get(`companyApi[${i}]`)
        });
    }

    const url = formData.get('deliveryType') === "fast" ? "delivery/calculate-fast-delivery" : "delivery/calculate-slow-delivery";
    let responseJson = [];
    let promise = await fetch(`http://127.0.0.1:8001/${url}`,{
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(jsonObject)
    })
        .then(async response => responseJson = await response.json());

    const parent = document.getElementById('parent');
    const formResponse = document.createElement("form");

    formResponse.id = 'responseForm';
    parent.appendChild(formResponse);
    apiDictionary = {
        delovyeLiniiApi: 'Деловые линии',
        pekApi: 'ПЭК'
    };
    responseJson.forEach((item) => {
        const div = document.createElement("div");
        div.innerHTML = `<text>${item.departureNumber}</text> <text>Цена:</text><input readonly placeholder="${item.price}" /> <text>Дата прибытия:</text><input readonly placeholder="${item.date}"/> <text>ТК:</text><input readonly placeholder="${apiDictionary[item.apiName]}">`;
        formResponse.appendChild(div);
    });
});
</script>