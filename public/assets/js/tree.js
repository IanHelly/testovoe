document.addEventListener('DOMContentLoaded', function () {
    // Находим все элементы с классом .employee-name
    const employeeNames = document.querySelectorAll('.employee-name');

    employeeNames.forEach(function (name) {
        name.addEventListener('click', function () {
            // Ищем вложенный <ul class="subordinates"> внутри текущего <li> элемента
            const subordinates = this.closest('li').querySelector('.subordinates');

            // Если нашли подчинённых, переключаем их видимость
            if (subordinates) {
                if (subordinates.style.display === 'none') {
                    subordinates.style.display = 'block'; // Показываем подчинённых
                } else {
                    subordinates.style.display = 'none'; // Скрываем подчинённых
                }
            }
        });
    });
});
