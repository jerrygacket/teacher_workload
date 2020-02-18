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

async function getChart(chartSet, chartId) {
    let data = {"chartSet": chartSet, "chartId": chartId};
    await sendRequest('index.php', data, 'GET')
        .then((response) =>  {
            if (response.error) {
                alert(response.message);
            }  else {
                setChart(response.result);
            }
            //console.log(result);
        }).catch((error) => console.log(error));
}

function setChart(chart) {
    //console.log(charts);
    ctx = document.getElementById(chart.chartId).getContext('2d');
    let newChart = new Chart(ctx, value);
    // for (let [key, value] of Object.entries(charts)) {
    //     //console.log(value);
    //
    // }
}