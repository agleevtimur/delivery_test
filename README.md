Проект релизован по [ТЗ](https://docs.google.com/forms/d/e/1FAIpQLSfG56O-7vRWnDTrMDYN6pSH3nv5QH3GAf7lYXdkNY1zqYEuBQ/viewform)

## Начало работы с проектом:
```
git clone https://github.com/agleevtimur/delivery_test
cd delivery_test
docker-compose up -d --build
```
+ не переименовывайте папку со склонированным репозиторием, она должна называться delivery_test
+ открыть в браузере localhost:8000
+ для добавления нового набора данных кликнуть на +
+ для выполнения запроса кликнуть на "Получить цены" (ответ придет для всех наборов данных вместе)

<img width="1363" alt="Screenshot 2023-10-25 at 23 39 28" src="https://github.com/agleevtimur/delivery_test/assets/42980610/81b0277b-299f-4a25-9bd0-0147ded6cd41">


### Дополнительная информация:
В Проекте с нуля частично реализованы некоторые компоненты фреймворков (Router, ServiceContainer, Dependency Injection). Также используется паттерн Strategy и множество DTO для работы с множеством АПИ.

Приложения:
+ WebForm - клиентское приложение
+ DeliveryAPI - основное приложение под ТЗ
+ DelovyeLiniiApi - эмулятор АПИ Деловых Линий
+ PekApi - эмулятор АПИ ПЭК


По-скольку проект приближен к реальным условиям, то на один и тот же вид доставки АПИ разных ТК возвращают разный json. Например, доставка FAST:


JSON Деловых линий
```
{
  'price': 120,
  'period': 3
}
```


JSON ПЭК
```
{
  'cost': 120,
  'period': 3
}
```

Порты WebForm(8000) и DeliveryAPI(8001) открыты снаружи, а порты DelovyeLiniiApi(8002) и PekApi(8003) закрыты. Они доступны только внутри сети docker контейнеров.


