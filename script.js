const submit_btn = document.getElementById("submit");
const data_table = document.getElementById("data");
const user_select = document.getElementById("user");

submit_btn.onclick = async function (e) {
  e.preventDefault();

  // Получаем выбранное значение пользователя
  const user_value = user_select.options[user_select.selectedIndex].value

  try {
    // Отправляем запрос на сервер
    const response = await fetch(`data.php?user=${user_value}`);
    if (!response.ok) {
      throw new Error("Ошибка загрузки");
    }

    // Ожидаем JSON-ответ
    const data = await response.json();

    // Находим таблицу и её tbody
    const table = data_table.querySelector("table");
    const tbody = document.getElementById("tbody");

    // Очищаем старые данные
    tbody.innerHTML = "";

    // Заполняем таблицу новыми данными
    Object.entries(data).forEach(([month, amount]) => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
                <td>${month}</td>
                <td>${amount}</td>
            `;
      tbody.appendChild(tr);
    });

    // Обновляем имя пользователя в заголовке
    const user_name = user_select.options[user_select.selectedIndex].text;
    data_table.querySelector("h2").textContent = `Transactions of ${user_name}`;

    // Показываем таблицу
    data_table.style.display = "block";
  } catch (error) {
    console.error("Ошибка:", error);
    alert("Ошибка, посмотрите консоль");
  }
};
