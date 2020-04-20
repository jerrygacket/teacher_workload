async function getChartList(chartSet) {
    let data = {"chartSet": chartSet, "list": "1"};
    await sendRequest('index.php', data, 'GET')
        .then((response) =>  {
            if (response.error) {
                alert(response.message);
            }  else {
                response.result.forEach((item) => getChart(chartSet, item));
            }
        })
        .catch((error) => console.log(error));
}

function addPosition(elem) {
    //alert(document.getElementById('position').value);
    let positions = document.getElementById('positions');
    pos = document.getElementById('position');
    occ = document.getElementById('occupation');
    rate = document.getElementById('rate');
    if (pos.value && occ.value) {
        if ((occ.options.selectedIndex == 1 || occ.options.selectedIndex == 2) && !rate.value) {
            alert('Нужно выбрать размер ставки!');
            return;
        }
        posId = pos.options.selectedIndex;
        posText = pos.options[posId].text;
        occId = occ.options.selectedIndex;
        occText = occ.options[occId].text;

        li = document.createElement('li');

        inputPos = document.createElement("input");
        inputPos.type = 'hidden';
        inputPos.name = 'posId[]';
        inputPos.value = pos.options[posId].value;
        li.appendChild(inputPos);

        inputOcc = document.createElement("input");
        inputOcc.type = 'hidden';
        inputOcc.name = 'occId[]';
        inputOcc.value = occ.options[occId].value;
        li.appendChild(inputOcc);

        button = document.createElement("a");
        button.href = '#';
        button.setAttribute('data-elemId', positions.childElementCount);
        button.onclick = function() {
            alert(this.dataset.elemid);
            delPosition(this.dataset.elemid);
        };
        button.className = 'btn btn-link m-0 red-text p-1'
        button.innerHTML = '<i class="fas fa-times"></i>';

        outText = 'Должность: ' + posText + ', Ставка: ' + occText;
        rateId = null;
        rateText = null;
        rateValue = null;
        if (rate.value) {
            rateId = rate.options.selectedIndex;
            rateText = rate.options[rateId].text;
            rateValue = rate.options[rateId].value;
            outText += ', Размер ставки: ' + rateText;
        }
        inputRate = document.createElement("input");
        inputRate.type = 'hidden';
        inputRate.name = 'rateId[]';
        inputRate.value = rateValue;
        li.appendChild(inputRate);

        li.appendChild(document.createTextNode(outText));
        li.appendChild(button);

        li.setAttribute("id", 'delBtn' + positions.childElementCount);

        positions.appendChild(li);
    }
}

function delPosition (id) {
    //positions = document.getElementById('positions');
    li = document.getElementById('delBtn' + id);
    li.parentNode.removeChild(li);
}

function selectOccupation(elem) {
    //alert(elem.value);
    if (elem.value == 3) {
        document.getElementById('rateSelect').classList.add('d-none');
    } else {
        document.getElementById('rateSelect').classList.remove('d-none');
    }
    document.getElementById('rate').value = '';
    //document.getElementById('rate').text = 'Разммер ставки...';
}