// async function getChartList(chartSet) {
//     let data = {"chartSet": chartSet, "list": "1"};
//     await sendRequest('index.php', data, 'GET')
//         .then((response) =>  {
//             if (response.error) {
//                 alert(response.message);
//             }  else {
//                 response.result.forEach((item) => getChart(chartSet, item));
//             }
//         })
//         .catch((error) => console.log(error));
// }
async function addPosition(elem) {
    let data = {};
    let positions = document.getElementById('positions');
    let pos = document.getElementById('position');
    let occ = document.getElementById('occupation');
    let rate = document.getElementById('rate');
    let posId = pos.options.selectedIndex;
    let occId = occ.options.selectedIndex;
    let rateId = rate.options.selectedIndex;
    if (occ.value) {
        if ((occId < 3) && (posId < 1)) {
            alert('Нужно выбрать должность!');
            return;
        } else {
        }
        if ((occId < 3) && !rate.value) {
            alert('Нужно выбрать размер ставки!');
            return;
        }
        data = {
            "posId": pos.value,
            "occId": occ.value,
            "rateId": rate.value,
            "id": positions.childElementCount
        };
    } else {
        alert('Нужно выбрать ставку!');
        return;
    }
    //
    await sendRequest('/users/add-position', data, 'GET')
        .then((response) =>  {
            if (response.error) {
                alert(response.message);
                console.log(response);
            }  else {
                setPosition(response.result);
            }
        })
        .catch((error) => console.log(error));
}

function setPosition(elements) {
    let ul = document.getElementById('positions');
    ul.innerHTML += elements;
}

function delPosition (li) {
    // console.log(id);
    if(confirm("Хотите удалить?")){
        // li = document.getElementById(id);
        li.parentNode.removeChild(li);
    } else {
        return false;
    }
    //positions = document.getElementById('positions');
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