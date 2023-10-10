<div id="parentId">
  <div>
    <text>Отправление 1</text>
      <input name="name[1]" type="text" placeholder="Начальный кладр" style="width:300px;" />
      <input name="name[2]" type="text" placeholder="Конечный кладр" style="width:300px;" />
      <input name="name[3]" type="number" placeholder="Вес груза" style="width:300px;" />
    <select size="1" name="type[1]" style="width:150px;">
      <option value="all">Все компании</option>
      <option value="pekApi">ПЭК</option>
      <option value="deloviyeLiniiApi">Деловые линии</option>
    </select>
    <a style="color:green;" onclick="return addField()" href="#">[+]</a>
  </div>
</div>

<script>
var countOfFields = 1; // Текущее число полей
var curFieldNameId = 1; // Уникальное значение для атрибута name
var maxFieldLimit = 25; // Максимальное число возможных полей
function deleteField(a) {
    if (countOfFields > 1)
    {
        // Получаем доступ к ДИВу, содержащему поле
        var contDiv = a.parentNode;
        // Удаляем этот ДИВ из DOM-дерева
        contDiv.parentNode.removeChild(contDiv);
        // Уменьшаем значение текущего числа полей
        countOfFields--;
    }
    // Возвращаем false, чтобы не было перехода по сслыке
    return false;
}
function addField() {
    // Проверяем, не достигло ли число полей максимума
    if (countOfFields >= maxFieldLimit) {
        alert("Число полей достигло своего максимума = " + maxFieldLimit);
        return false;
    }
    // Увеличиваем текущее значение числа полей
    countOfFields++;
    // Увеличиваем ID
    curFieldNameId++;
    // Создаем элемент ДИВ
    var div = document.createElement("div");
    // Добавляем HTML-контент с пом. свойства innerHTML
    div.innerHTML = `<text>Отправление ${curFieldNameId}</text><input name="name[` + curFieldNameId + "]\" type=\"text\" style=\"width:300px;\" /> <select size=\"1\" name=\"type[" + curFieldNameId + "]\" style=\"width:150px;\"><option value=\"text\">Текстовое поле</option><option value=\"int\">Целое число</option><option value=\"float\">Число-цена</option></select> <a style=\"color:red;\" onclick=\"return deleteField(this)\" href=\"#\">[—]</a> <input name=\"url[" + curFieldNameId + "]\" type=\"text\" style=\"width:300px;\" /> <a style=\"color:green;\" onclick=\"return addField()\" href=\"#\">[+]</a>";
    // Добавляем новый узел в конец списка полей
    document.getElementById("parentId").appendChild(div);
    // Возвращаем false, чтобы не было перехода по сслыке
    return false;
}
</script>