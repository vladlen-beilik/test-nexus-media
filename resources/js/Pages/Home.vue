<template>
    <div class="card">
        <div class="index-table-wrapper">
            <div class="index-table-header">
                <div class="index-table-header-filter">
                    <div class="col-left">
                        <div class="resptabs tabs3 --jsfied">
                            <ul class="primary-list">
                                <li v-for="status in financialStatuses">
                                    <button
                                        style="text-transform: capitalize;"
                                        class="tab-item"
                                        :class="{'active': status === financialStatus}"
                                        @click="changeFinancialStatus(status)"
                                    >{{ !status ? 'all' : status }}</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-right">
                        <div
                            class="dropdown"
                            :class="{'show': dropdownShow}"
                            v-click-away="onClickAway"
                        >
                            <button
                                class="btn btn-icon btn-no-label btn-sort dropdown-toggle"
                                :class="{'show': dropdownShow}"
                                @click="dropdownShow = !dropdownShow"
                            >
                                <span class="btn-icon-holder">
                                    <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg_375hu" focusable="false" aria-hidden="true">
                                        <path d="M7.75 6.06v7.69a.75.75 0 0 1-1.5 0v-7.69l-1.72 1.72a.75.75 0 0 1-1.06-1.06l3-3a.75.75 0 0 1 1.06 0l3 3a.75.75 0 1 1-1.06 1.06l-1.72-1.72Z"></path>
                                        <path d="M13.75 6.25a.75.75 0 0 0-1.5 0v7.69l-1.72-1.72a.75.75 0 1 0-1.06 1.06l3 3a.75.75 0 0 0 1.06 0l3-3a.75.75 0 1 0-1.06-1.06l-1.72 1.72v-7.69Z"></path>
                                    </svg>
                                </span>
                                Sort
                            </button>
                            <ul
                                class="dropdown-menu align-right"
                                :class="{'show': dropdownShow}"
                            >
                                <li>
                                    <button @click="importData">Import</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="index-table-inner">
                <div class="index-table-header-action">
                    <div class="index-table-header-inner">
                        <div class="form-checkbox">
                            <label>
                                <input type="checkbox">
                                <span class="checkbox-icon"></span>
                                <span class="label-text">2 Selected</span>
                            </label>
                        </div>
                        <button class="link">Cancel</button>
                    </div>
                </div>
                <table class="index-table">
                    <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th>Customer Email</th>
                        <th>Total Price</th>
                        <th>Financial Status</th>
                        <th>Fulfillment Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="order in resource.data">
                        <td>{{ getCustomerName(order) }}</td>
                        <td>{{ getCustomerEmail(order) }}</td>
                        <td>${{ order.total_price || '$0' }}</td>
                        <td>
                            <span v-if="order.financial_status" class="badge" :class="getFinancialStatusClass(order)">{{ order.financial_status }}</span>
                            <template v-else>-</template>
                        </td>
                        <td>
                            <span v-if="order.fulfillment_status" class="badge badge-info">{{ order.fulfillment_status }}</span>
                            <template v-else>-</template>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="index-table-footer">
                <div class="table-result">Showing {{ resource.from }}-{{ resource.to }} of {{ resource.total }} results</div>
                <div class="button-group">
                    <button
                        @click="getPageQuery(resource.prev_page_url)"
                        class="btn btn btn-icon btn-no-label"
                        :class="{'disabled-link': resource.current_page === 1}"
                        :disabled="resource.current_page === 1 ? true : null"
                    >
                        <span class="btn-icon-holder">
                            <svg viewBox="0 0 20 20" class="Icon_Icon__Dm3QW" style="width: 20px; height: 20px;">
                                <path d="M12 16a.997.997 0 0 1-.707-.293l-5-5a.999.999 0 0 1 0-1.414l5-5a.999.999 0 1 1 1.414 1.414l-4.293 4.293 4.293 4.293a.999.999 0 0 1-.707 1.707z"></path>
                            </svg>
                        </span>
                        prev
                    </button>
                    <button
                        @click="getPageQuery(resource.next_page_url)"
                        class="btn btn btn-icon btn-no-label"
                        :class="{'disabled-link': resource.last_page === resource.current_page}"
                        :disabled="resource.last_page === resource.current_page ? true : null"
                    >
                        <span class="btn-icon-holder">
                            <svg viewBox="0 0 20 20" class="Icon_Icon__Dm3QW" style="width: 20px; height: 20px;">
                                <path d="M8 16a.999.999 0 0 1-.707-1.707l4.293-4.293-4.293-4.293a.999.999 0 1 1 1.414-1.414l5 5a.999.999 0 0 1 0 1.414l-5 5a.997.997 0 0 1-.707.293z"></path>
                            </svg>
                        </span>
                        next
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Layout from '@/Shared/Layout.vue';
import axios from "axios";

export default {
    layout: Layout,
    props: {
        orders: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            resource: JSON.parse(JSON.stringify(this.orders)),
            currentPage: 1,
            financialStatus: null,
            financialStatuses: [null, 'paid', 'pending', 'refunded'],
            dropdownShow: false,
            truncated: false
        }
    },
    created() {

    },
    methods: {
        getCustomerName(order) {
            return order.hasOwnProperty('customer') && order.customer && order.customer.hasOwnProperty('name') ? order.customer.name : '-'
        },
        getCustomerEmail(order) {
            return order.hasOwnProperty('customer') && order.customer && order.customer.hasOwnProperty('email') ? order.customer.email : '-'
        },
        getPageQuery(url) {
            const queryString = url.split('?')[1]
            const params = new URLSearchParams(queryString)
            this.currentPage = params.get('page')
            this.getData()
        },
        changeFinancialStatus(status) {
            this.financialStatus = status
            this.currentPage = 1
            this.getData()
        },
        getFinancialStatusClass(order) {
            if (order.financial_status === 'paid') return 'badge-success'
            else if (order.financial_status === 'pending') return 'badge-warning'
            else if (order.financial_status === 'refunded') return 'badge-danger'
            else return 'badge-info'
        },
        getData() {
            this.resource = []
            axios.post('/data', {
                'page': this.currentPage,
                'financialStatus': this.financialStatus,
                'truncated': this.truncated,
            }).then(response => {
                this.resource = response.data
            })
        },
        importData() {
            this.dropdownShow = false
            this.truncated = true
            this.financialStatus = null
            this.currentPage = 1
            this.getData()
        },
        onClickAway() {
            this.dropdownShow = false
        },
    }
}
</script>
