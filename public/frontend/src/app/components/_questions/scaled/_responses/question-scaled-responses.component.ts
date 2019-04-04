import {Component, Input} from "@angular/core";
import {QuestionScaled} from "../../../../models/question-scaled";
import {QuestionScaledResponse} from "../../../../models/question-scaled-response";
import {faChartBar, faChartLine, faChartPie, faTable} from "@fortawesome/free-solid-svg-icons";
import {ChartOptions, ChartType} from "chart.js";
import {Label, SingleDataSet} from "ng2-charts";

@Component({
    selector: "app-question-scaled-responses",
    templateUrl: "./question-scaled-responses.component.html",
    styleUrls: ["./question-scaled-responses.component.css"],
})
export class QuestionScaledResponsesComponent {
    @Input() question: QuestionScaled;
    @Input() responses: QuestionScaledResponse[];

    icons = {
        pie: faChartPie,
        bar: faChartBar,
        line: faChartLine,
        table: faTable,
    };

    isTable: boolean = false;
    hideNoResponses: boolean = false;
    
    chartOptions: ChartOptions = {
        responsive: true,
    };
    chartLabels: Label[] = [];
    chartData: SingleDataSet = [];
    chartType: ChartType = "pie";
    chartLegend = true;

    ngOnInit() {
        let labels = [];
        let data = [];

        if (this.question.type === "star") {
            // Iterate upto max number and add label and set each data to 0
            for (let i = 0; i < this.question.max; i++) {
                labels.push(`${i + 1} ${i === 0 ? 'Star' : 'Stars'}`);
                data.push(0);
            }
            
            this.responses.forEach(response => data[response.response - 1] += 1);
        } else {
            this.chartType = "line";

            for (let i = -1; i < this.question.max; i+=this.question.interval) {
                labels.push(i+1);
                data.push(0);
            }
            
            this.responses.forEach(response => data[response.response/this.question.interval] += 1);

            this.chartLegend = false;
            this.chartOptions = {
                responsive: true,
                scales: {
                    xAxes: [{
                        ticks: {
                            beginAtZero: true
                        },
                        scaleLabel: {
                            display: true,
                            labelString: "Slider Value"
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        },
                        scaleLabel: {
                            display: true,
                            labelString: "Responses"
                        }
                    }]
                }
            };
        }
        
        this.chartLabels = labels;
        this.chartData = data;
    }

    /**
     * Changes the chart type.
     *
     * @param {string} type - Updates the type of graph used to show the data.
     */
    changeChartType(type) {
        this.isTable = false;
        
        if (type === "pie") {
            this.chartType = "pie";

            this.chartOptions = {
                responsive: true,
            };
            this.chartLegend = true;
        } else if (type === "bar") {
            this.chartType = "bar";
            this.chartOptions = {
                responsive: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        },
                        scaleLabel: {
                            display: true,
                            labelString: "Responses"
                        }
                    }]
                }
            };
            this.chartLegend = false;
        } else if (type === "horizontalBar") {
            this.chartType = "horizontalBar";
            this.chartOptions = {
                responsive: true,
                scales: {
                    xAxes: [{
                        ticks: {
                            beginAtZero: true
                        },
                        scaleLabel: {
                            display: true,
                            labelString: "Responses"
                        }
                    }]
                }
            };
            this.chartLegend = false;
        } else if (type === "line") {
            this.chartType = "line";
            
            // No need to set chart options as they will never get changed
        } else if (type === "table") {
            this.isTable = true;
            this.hideNoResponses = false;
        }
    }
}

