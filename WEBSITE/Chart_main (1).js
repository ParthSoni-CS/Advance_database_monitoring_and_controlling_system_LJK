let barChart
let barChart1
let lineChart
let lineChart1
let lineChart2
let lineChart3
bar = false
// count = 0
var trigger
function appendLeadingZeroes(n) {
    if (n <= 9) {
        return "0" + n;
    }
    return n
}

function load_data(Building = $('#Building_name').text(), Room = $('#Room_number').text()) {

    console.log(Building, Room);
    var action = "Fetch_json";
    //var Data;

    return $.parseJSON($.ajax({
        url: 'fetch_cth_json.php',
        method: 'post',
        dataType: 'json',
        async: false,
        data: { action: action, Building_name: Building, Room_number: Room },
        success: function (response) {



        }
    }).responseText);


}

function changeDateRange() {

    $('#dates').on('apply.daterangepicker', function (ev, picker) {
        StartD = (bar) ? picker.startDate.format('YYYY-MM-DD') : picker.startDate.format('YYYY-MM-DD HH:mm:ss');
        EndD = (bar) ? picker.endDate.format('YYYY-MM-DD') : picker.endDate.format('YYYY-MM-DD HH:mm:ss');
        $("#date-slider").slider('values', [StartD, EndD]);


        $("#dateLabel1").text(StartD);

        $("#dateLabel2").text(EndD);


        StartD = (bar) ? parseTime_bar(StartD).getTime() : parseTime(StartD).getTime();
        EndD = (bar) ? parseTime_bar(EndD).getTime() : parseTime(EndD).getTime();
        $('#date-slider').slider({ min: StartD, max: EndD, values: [StartD, EndD] })


        if (bar) {
            barChart.wrangleData();
        }
        else {
            updateCharts();
            lineChart.wrangleData();
        }

    });

}

data = load_data();
//console.log("dataaaa", data)
data1 = JSON.parse(JSON.stringify(data));

//console.log("data", data)
data.forEach(d => {
    d.consumption = parseFloat(d.consumption)
    d.temperature = parseFloat(d.temperature)
    d.humidity = parseFloat(d.humidity)
})

data1.forEach(d => {
    d.date = d.tot.split(" ")[0]
})

data1.forEach(d => {
    d.temperature = parseFloat(d.temperature)
    d.humidity = parseFloat(d.humidity)
    d.consumption = parseFloat(d.consumption)
})


// Parser and Formatter for Bar graph
const parseTime_bar = d3.timeParse("%Y-%m-%d")
const formatTime_bar = d3.timeFormat("%Y-%m-%d")
const formatTime_bar2 = d3.timeFormat("%a %b %d, %y")
const bisectDate_bar = d3.bisector(d => d.date).left;
// data1.forEach(d => {
//     d.date = parseTime_bar(d.date)
// })



//console.log("data1", data1)
var entries = d3.nest()
    .key(function (d) { return d.date })
    .entries(data1)

updated_entries = []
//console.log("entries", entries)
entries.forEach(function (d) {
    var t = 0
    var h = 0
    var c = 0
    l = d.values.length
    console.log(l)
    for (i = 0; i < l; i++) {
        t += d.values[i].temperature;
        h += d.values[i].humidity;
        c += d.values[i].consumption;
    }

    updated_entries.push({ date: d.key, avg_temperature: (t / l), avg_humidity: (h / l), total_consumption: c })

    console.log("Total temp", t)
    console.log("Total humid", h)
    console.log("Total consumption", c)
})
//entries
updated_entries.forEach(d => d.date = parseTime_bar(d.date))
updated_entries.forEach(d => d.date = formatTime_bar2(d.date))

console.log("updated_entries", updated_entries)

// data1.forEach(d => {
//     d.date = parseTime_bar(d.date)
// })


// Parser and Formatter for line graph
const parseTime = d3.timeParse("%Y-%m-%d %H:%M:%S")
const formatTime = d3.timeFormat("%Y-%m-%d %H:%M:%S")
const bisectDate = d3.bisector(d => d.tot).left;
data.forEach(d => {
    d.tot = parseTime(d.tot)

})

//Setting initial dates for line 
var dates = data.map(function (x) { return new Date(x.tot); })
console.log("dates", dates)
var latest = new Date(Math.max.apply(null, dates));
latest.setMinutes(latest.getMinutes() + 58)
let latest_formatted_date = latest.getFullYear() + "-" + appendLeadingZeroes(latest.getMonth() + 1) + "-" + appendLeadingZeroes(latest.getDate()) + " " + appendLeadingZeroes(latest.getHours()) + ":" + appendLeadingZeroes(latest.getMinutes()) + ":" + appendLeadingZeroes(latest.getSeconds())
let latest_formatted_date_bar = latest.getFullYear() + "-" + appendLeadingZeroes(latest.getMonth() + 1) + "-" + appendLeadingZeroes(latest.getDate())

//console.log(latest_formatted_date)

var earliest = new Date(Math.min.apply(null, dates));
let earliest_formatted_date = earliest.getFullYear() + "-" + appendLeadingZeroes(earliest.getMonth() + 1) + "-" + appendLeadingZeroes(earliest.getDate()) + " " + appendLeadingZeroes(earliest.getHours()) + ":" + appendLeadingZeroes(earliest.getMinutes()) + ":" + appendLeadingZeroes(earliest.getSeconds())
let earliest_formatted_date_bar = earliest.getFullYear() + "-" + appendLeadingZeroes(earliest.getMonth() + 1) + "-" + appendLeadingZeroes(earliest.getDate())


$('#dates').daterangepicker({

    timePicker: true,

    startDate: (bar) ? earliest_formatted_date_bar : earliest_formatted_date,
    endDate: (bar) ? latest_formatted_date_bar : latest_formatted_date,
    minDate: (bar) ? earliest_formatted_date_bar : earliest_formatted_date,
    maxDate: (bar) ? latest_formatted_date_bar : latest_formatted_date,
    locale: {
        format: (bar) ? 'YYYY-MM-DD' : 'YYYY-MM-DD hh:mm:ss A'
    }

});



$("#var-select").on("change", function () {
    if (this.value == "all") {
        //console.log("all called")
        var u = document.getElementById('txt_tot')
        var v = document.getElementById('txt_val_tot')
        var d = document.getElementById('txt')
        var g = document.getElementById('bar-value')
        var e = document.getElementById('txt_val')
        var f = document.getElementById('all-value');
        var y = document.getElementById("individual_line");
        var x = document.getElementById("allinclusive");
        var z = document.getElementById("individual_bar");
        x.style.display = "block";
        y.style.display = "none";
        z.style.display = "none";
        f.style.display = "block"
        d.style.display = "none";
        e.style.display = "none";
        g.style.display = "none";
        u.style.display = "none";
        v.style.display = "none";

        bar = false;

        updateCharts();
    }


    else if (this.value === "total_power") {
        // $("#dateLabel2").text(latest_formatted_date_bar);
        // $('#dateLabel1').text(earliest_formatted_date_bar);
        var u = document.getElementById('txt_tot')
        var v = document.getElementById('txt_val_tot')
        var f = document.getElementById('all-value');
        var d = document.getElementById('txt')
        var g = document.getElementById('bar-value')
        var e = document.getElementById('txt_val')
        var a = document.getElementById("individual_bar");
        var b = document.getElementById("individual_line");
        var c = document.getElementById("allinclusive");

        a.style.display = "block";
        b.style.display = "none";
        c.style.display = "none";
        f.style.display = "none"
        d.style.display = "none";
        e.style.display = "none";
        g.style.display = "block";
        u.style.display = "none";
        v.style.display = "none";
        bar = true;
        //ChangeDateRange1()
        barChart.wrangleData();

    }
    else {
        if(this.value === "consumption")
        {   
            var u = document.getElementById('txt_tot')
            var v = document.getElementById('txt_val_tot')
            var d = document.getElementById('txt')
            var f = document.getElementById('all-value');
            var g = document.getElementById('bar-value')
            var e = document.getElementById('txt_val')
            var b = document.getElementById("individual_bar");
            var a = document.getElementById("individual_line");
            var c = document.getElementById("allinclusive");
            f.style.display = "none"
            a.style.display = "block";
            b.style.display = "none";
            c.style.display = "none";
            d.style.display = "block"
            e.style.display = "block";
            g.style.display = "none";
            u.style.display = "block";
            v.style.display = "block";
    
            bar = false;
            lineChart.wrangleData();
            //slider()
            
        }
        else
        {
            var u = document.getElementById('txt_tot')
            var v = document.getElementById('txt_val_tot')
            var d = document.getElementById('txt')
            var f = document.getElementById('all-value');
            var g = document.getElementById('bar-value')
            var e = document.getElementById('txt_val')
            var b = document.getElementById("individual_bar");
            var a = document.getElementById("individual_line");
            var c = document.getElementById("allinclusive");
            f.style.display = "none"
            a.style.display = "block";
            b.style.display = "none";
            c.style.display = "none";
            d.style.display = "block"
            e.style.display = "block";
            g.style.display = "none";
            u.style.display = "none";
            v.style.display = "none";
    
            bar = false;
            lineChart.wrangleData();
            //slider()
        }
    }

}
)
console.log("Update is called")
// add jQuery UI slider
if (bar) {
    $("#dateLabel2").text(latest_formatted_date_bar);
    $('#dateLabel1').text(earliest_formatted_date_bar);
}
$("#dateLabel2").text(latest_formatted_date);
$('#dateLabel1').text(earliest_formatted_date);


changeDateRange();
$("#date-slider").slider({
    range: true,
    max: (bar) ? parseTime_bar(latest_formatted_date_bar).getTime() : parseTime(latest_formatted_date).getTime(),
    min: (bar) ? parseTime_bar(earliest_formatted_date_bar).getTime() : parseTime(earliest_formatted_date).getTime(),
    step: (bar) ? 86400000 : 432000,
    values: [
        (bar) ? parseTime_bar(earliest_formatted_date_bar).getTime() : parseTime(earliest_formatted_date).getTime(),
        (bar) ? parseTime_bar(latest_formatted_date_bar).getTime() : parseTime(latest_formatted_date).getTime()

    ],
    slide: (event, ui) => {
        $("#dateLabel1").text((bar) ? formatTime_bar(new Date(ui.values[0])) : formatTime(new Date(ui.values[0])))
        $("#dateLabel2").text((bar) ? formatTime_bar(new Date(ui.values[1])) : formatTime(new Date(ui.values[1])))
        //console.log(formatTime(new Date(ui.values[0])));
        $('#dates').data('daterangepicker').setStartDate((bar) ? formatTime_bar(new Date(ui.values[0])) : formatTime(new Date(ui.values[0])));
        $('#dates').data('daterangepicker').setEndDate((bar) ? formatTime_bar(new Date(ui.values[1])) : formatTime(new Date(ui.values[1])));


        if (bar) {
            barChart.wrangleData();
        }
        else {
            updateCharts();
            lineChart.wrangleData();
        }
    }

})

//slider();

barChart = new BarChart("#chart-area_bar")
barChart1 = new BarChart('#chart-area4', _width = 550, _height = 400, _left = 80, _right = 10, _top = 50, _bottom = 50, _value = "bar")
lineChart1 = new LineChart('#chart-area1', _width = 550, _height = 400, _left = 80, _right = 10, _top = 50, _bottom = 50, _value = "temperature", _xticks = 6)
lineChart2 = new LineChart('#chart-area2', _width = 550, _height = 400, _left = 80, _right = 10, _top = 50, _bottom = 50, _value = "humidity", _xticks = 6)
lineChart3 = new LineChart('#chart-area3', _width = 550, _height = 400, _left = 80, _right = 10, _top = 50, _bottom = 50, _value = "consumption", _xticks = 6)
lineChart = new LineChart("#chart-area")



function updateCharts() {
    // lineChart.wrangleData()
    barChart1.wrangleData()
    lineChart1.wrangleData()
    lineChart2.wrangleData()
    lineChart3.wrangleData()

}