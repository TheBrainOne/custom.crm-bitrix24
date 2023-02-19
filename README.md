# custom.crm-bitrix24
Кастомные компоненты для Битрикс24 выполняющие следующий функционал:

## deals.list
Компонент выводит список сделок по направлениям.

Имеет настраиваемые параметры:
- выбор направления
- заголовок страницы

В шаблоне компонента выводится список сделок в таблицу с колонками:

| ID     | Название сделки | Дата создания | Кто создал |
|--------|-----------------|---------------|------------|


## deal.add
Компонент создает сделку и задачу к ней

Имеет настраиваемый параметр:
- выбор проекта

В шаблоне компонента реализована форма, при заполнении и отправке которой создается сделка и связанная задача. Данные для задачи берутся из полей формы.
