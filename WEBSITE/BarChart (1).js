class BarChart {
    constructor(_parentElement, _width = 1100, _height = 650, _left = 100, _right = 100, _top = 50, _bottom = 100, _value = null, _xticks = null) {
        this.parentElement = _parentElement
        this.width = _width
        this.height = _height
        this.left = _left
        this.right = _right
        this.top = _top
        this.bottom = _bottom
        this.value = _value
        this.xticks = _xticks

        this.initVis()
    }
    initVis() {
        const vis = this
        vis.MARGIN = { LEFT: vis.left, RIGHT: vis.right, TOP: vis.top, BOTTOM: vis.bottom }
        vis.WIDTH = vis.width - vis.MARGIN.LEFT - vis.MARGIN.RIGHT
        vis.HEIGHT = vis.height - vis.MARGIN.TOP - vis.MARGIN.BOTTOM

        vis.svg = d3.select(vis.parentElement).append("svg")
            .attr("width", vis.WIDTH + vis.MARGIN.LEFT + vis.MARGIN.RIGHT)
            .attr("height", vis.HEIGHT + vis.MARGIN.TOP + vis.MARGIN.BOTTOM)
        // vis.tip = d3.tip()
        //     .attr('class', 'd3-tip')
        //     .html(d => {
        //         let text = `<strong>Total consumption:</strong> <span style='color:red;text-transform:capitalize'>${d.total_consumption}</span><br>`
        //         text += `<strong>avg. Temperature:</strong> <span style='color:red;text-transform:capitalize'>${d.avg_temperature}</span><br>`
        //         text += `<strong>avg. Humidity:</strong> <span style='color:red'>${d.avg_humidity}</span><br>`
        //         text += `<strong>Total Time:</strong> <span style='color:red'>HH:mm:ss</span><br>`

        //         return text
        //     })
        vis.tip = d3.tip()
            .attr('class', 'd3-tip')
            .offset([-10, 0])
            .html(function (d) {
                let text = `<strong>Total Power:</strong> <span style='color:red'>${d.total_consumption}</span><br>`
                text += `<strong>Avg. Temperature:</strong> <span style='color:red'> ${d3.format(".2f")(d.avg_temperature)
                    } </span > <br>`
                text += `<strong>Avg. Humidity:</strong> <span style='color:red'>${d3.format(".2f")(d.avg_humidity)}</span><br>`
                text += `<strong>Total Time:</strong> <span style='color:red'>HH:MM:SS</span><br>`

                return text
            })
        vis.g = vis.svg.append("g")
            .attr("transform", `translate(${vis.MARGIN.LEFT}, ${vis.MARGIN.TOP})`)
        const parseTime_bar = d3.timeParse("%Y-%m-%d")
        const formatTime_bar = d3.timeFormat("%Y-%m-%d")
        const bisectDate_bar = d3.bisector(d => d.date).left;
        vis.g.call(vis.tip)
        // X label
        vis.xLabel = vis.g.append("text")
            .attr("class", "x axis-label")
            .attr("y", vis.HEIGHT + 50)
            .attr("x", vis.WIDTH / 2)
            .attr("font-size", "20px")
            .attr("text-anchor", "middle")
            .text("Date")

        // Y label
        if (vis.value == null) {
            vis.yLabel = vis.g.append("text")
                .attr("class", "y axisLabel")
                .attr("transform", "rotate(-90)")
                .attr("y", -60)
                .attr("x", -170)
                .attr("font-size", "20px")
                .attr("text-anchor", "middle")
                .text("Total Power")
        }

        else {
            vis.yLabel = vis.g.append("text")
                .attr("class", "y axisLabel")
                .attr("transform", "rotate(-90)")
                .attr("y", -40)
                .attr("x", -85)
                .attr("font-size", "17px")
                .attr("text-anchor", "middle")
                .text("Total Power")
        }


        vis.x = d3.scaleBand()
            .range([0, vis.WIDTH])
            .paddingInner(0.3)
            .paddingOuter(0.2)

        vis.y = d3.scaleLinear().range([vis.HEIGHT, 0])
        vis.xAxisCall = d3.axisBottom()


        vis.yAxisCall = d3.axisLeft()
            .ticks(7)

        vis.xAxis = vis.g.append("g")
            .attr("class", "x axis")
            .attr("transform", `translate(0, ${vis.HEIGHT})`)
        vis.yAxis = vis.g.append("g")
            .attr("class", "y axis")

        vis.wrangleData()
    }
    wrangleData() {
        const vis = this
        vis.sliderValues = $("#date-slider").slider("values")
        vis.dataTimeFiltered_bar = updated_entries.filter(d => {
            return ((new Date(d.date) >= (vis.sliderValues[0] - 86400000)) && (new Date(d.date) <= vis.sliderValues[1]))
        })
        console.log("dateTimeFiltered_bar", this.dataTimeFiltered_bar)

        //da

        vis.updateData()
    }

    updateData() {
        const vis = this


        vis.t = d3.transition().duration(1000)
        vis.x.domain(vis.dataTimeFiltered_bar.map(d => d.date))
        vis.y.domain([
            0,
            d3.max(vis.dataTimeFiltered_bar, d => d.total_consumption) * 1.005
        ])


        let p = 0
        vis.dataTimeFiltered_bar.forEach(d => {
            p += d.total_consumption
        }
        )
        d3.select('#txt_bar').text("Total power")
        d3.select('#txt_val_bar').text(p)
        d3.select('#txt_Tpower').text("Total power")
        d3.select('#txt_val_Tpower').text(p)


        vis.xAxisCall.scale(vis.x)
        vis.xAxis.transition(vis.t).call(vis.xAxisCall)
        vis.yAxisCall.scale(vis.y)
        vis.yAxis.transition(vis.t).call(vis.yAxisCall)

        vis.rects = vis.g.selectAll("rect")
            .data(vis.dataTimeFiltered_bar)

        vis.rects.exit()
            .attr("class", "exit")
            .transition(vis.t)
            .attr("height", 0)
            .attr("y", vis.HEIGHT)
            .remove()

        vis.rects
            .attr("class", "update")
            .transition(vis.t)
            .attr("y", d => vis.y(d.total_consumption))
            .attr("height", d => (vis.HEIGHT - vis.y(d.total_consumption)))
            .attr("x", d => vis.x(d.date))
            .attr("width", vis.x.bandwidth)

        vis.rects.enter().append("rect")
            .attr("class", "enter")
            .attr("y", d => vis.y(d.total_consumption))
            .attr("height", d => (vis.HEIGHT - vis.y(d.total_consumption)))
            .attr("x", d => vis.x(d.date))
            .attr("width", vis.x.bandwidth)
            .attr("fill", "#cce")
            .on("mouseover", vis.tip.show)
            .on("mouseout", vis.tip.hide)

    }
}