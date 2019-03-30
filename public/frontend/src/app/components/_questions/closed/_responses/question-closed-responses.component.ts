import {Component, Input, OnInit, ViewChild} from "@angular/core";
import {QuestionOpen} from "../../../../models/question-open";
import {QuestionClosedOption} from "../../../../models/question-closed-option";
import {Label, SingleDataSet} from "ng2-charts";
import {ChartOptions, ChartType} from "chart.js";
import {faChartBar, faChartPie} from "@fortawesome/free-solid-svg-icons";

@Component({
    selector: "app-question-closed-responses",
    templateUrl: "./question-closed-responses.component.html",
    styleUrls: ["./question-closed-responses.component.css"],
})
export class QuestionClosedResponsesComponent implements OnInit {
    @Input() question: QuestionOpen;
    @Input() options: QuestionClosedOption[];
    
    icons = {
        pie: faChartPie,
        bar: faChartBar,
    };
    
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
        
        this.options.forEach(option => {
            labels.push(option.option);
            data.push(option.responses);
            
            this.chartLabels = labels;
            this.chartData = data;
        })
    }

    /**
     * Changes the chart type.
     * 
     * @param {string} type - Updates the type of graph used to show the data.
     */
    changeChartType(type) {
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
                        }
                    }]
                }
            };
            this.chartLegend = false;
        }
    }
}

