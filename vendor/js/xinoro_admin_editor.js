// Переключатель навигации
let selectedCategory = "none";

window.addEventListener('load', () => loadToolMenu());

function loadToolMenu()
{
    for(let div of document.querySelectorAll("#nav-btn")) {
        div.addEventListener("click", function(e) {
    
            $('#items-box').children().remove();
    
            // Заполнение блоками и включение анимации
            if(!$("#items-box").hasClass("design-box-open"))
            {
                $("#items-box").removeClass("desing-box-close").addClass("design-box-open");
                loadToolBox(this.getAttribute("type"));
                selectedCategory = this.getAttribute("type");
            }
            else
            {
                $("#items-box").removeClass("design-box-open").addClass("desing-box-close");
                if(this.getAttribute("type") != selectedCategory)
                {
                    setTimeout(() => $("#items-box").removeClass("desing-box-close").addClass("design-box-open"), 100);
                    loadToolBox(this.getAttribute("type"));
                    selectedCategory = this.getAttribute("type");
                }
            }
        });
    }

    // Настройка полей текста(Открытие редактора по клику на текст)
    var TextBox = document.querySelectorAll("#xinoro_text_ed");
    for (var i = 0; i < TextBox.length; i++) {
        TextBox[i].onfocus = function(){
            $('.text-editor-tools-r1').css('display','flex'); 
        };
    }
}

// Отправка запроса на блок
// type - тип блоков на вытягивание
function loadToolBox(type)
{
    setTimeout(() => $.ajax({
        url: "admin/ajax",
        type: "POST",
        data: {
        type: "getBlocksCategory",
        category: type,
        },
        success: function(result) {
            document.getElementById("items-box").innerHTML += result.substr(result.indexOf("<body>", "</body>"));  
        }
    }), 400);
}

// Удаление блоков в редакторе
function boxDelete(object)
{
    ($($(object).parent()).parent()).remove();
}