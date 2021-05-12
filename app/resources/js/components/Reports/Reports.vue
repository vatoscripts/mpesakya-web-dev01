<template>
    <div class="content-wrapper">
        <h4 class="content-heading">
            <div>
                M-pesa KYA Portal
                <p class="lead mt-2">Reports</p>
            </div>
        </h4>
        <div class="vld-parent" ref="formContainer">
            <div class="row">
                <!-- START dashboard main content-->
                <div class="col-xl-12">
                    <div
                        v-show="message"
                        class="alert alert-danger alert-block mt-1 text-center"
                    >
                        <button
                            type="button"
                            class="close"
                            data-dismiss="alert"
                        >
                            ×
                        </button>
                        <span class="lead">{{ message }}</span>
                    </div>
                    <div class="card" id="filterAgentLocation">
                        <div class="card-body">
                            <form @submit.prevent="submit" class="mb-3">
                                <div class="align-center">
                                    <div class="form-row">
                                        <div class="form-group col-3">
                                            <label class="text-bold"
                                                >Start Date</label
                                            >
                                            <datepicker
                                                placeholder="Select Date"
                                                input-class="form-control"
                                                v-model="fields.startDate"
                                                name="startDate"
                                                :disabled-dates="
                                                    startState.disabledDates
                                                "
                                                :typeable="true"
                                            ></datepicker>
                                            <div
                                                v-if="
                                                    errors && errors.startDate
                                                "
                                                class="text-danger"
                                            >
                                                {{ errors.startDate[0] }}
                                            </div>
                                        </div>

                                        <div class="form-group col-3">
                                            <label class="text-bold"
                                                >End Date</label
                                            >
                                            <datepicker
                                                placeholder="Select Date"
                                                input-class="form-control"
                                                v-model="fields.endDate"
                                                name="endDate"
                                                :disabled-dates="
                                                    endState.disabledDates
                                                "
                                                :typeable="true"
                                            ></datepicker>
                                            <div
                                                v-if="errors && errors.endDate"
                                                class="text-danger"
                                            >
                                                {{ errors.endDate[0] }}
                                            </div>
                                        </div>

                                        <div class="form-group col-3">
                                            <label class="text-bold"
                                                >Report category</label
                                            >
                                            <select
                                                class="custom-select text-center"
                                                id="country-select"
                                                name="country"
                                                :disabled="isCategoryFetched"
                                                @change="
                                                    onReportCategoryChange(
                                                        $event
                                                    )
                                                "
                                            >
                                                <option value
                                                    >SELECT ONE</option
                                                >

                                                <option
                                                    v-for="category in categories"
                                                    v-bind:value="category.ID"
                                                    v-bind:key="category.ID"
                                                >
                                                    {{ category.ReportName }}
                                                </option>
                                            </select>
                                            <div
                                                v-if="
                                                    errors &&
                                                        errors.reportCategory
                                                "
                                                class="text-danger"
                                            >
                                                {{ errors.reportCategory[0] }}
                                            </div>
                                        </div>

                                        <div class="form-group col-3">
                                            <button
                                                id="filterRegJourneyDates"
                                                type="submit"
                                                class="btn btn-lg btn-block btn-outline-primary text-bold mt-4"
                                            >
                                                Download Report
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END dashboard main content-->
    </div>
</template>
<script>
import Datepicker from "vuejs-datepicker";

export default {
    components: {
        Datepicker
    },
    data() {
        return {
            fields: {},
            errors: {},
            success: false,
            loaded: true,
            loading: true,
            message: null,
            categories: {},
            isCategoryFetched: true,
            startState: {
                disabledDates: {
                    to: new Date(2019, 11, 25), // Disable all dates after specific date
                    from: new Date() // Disable all dates up to specific date
                }
            },
            endState: {
                disabledDates: {
                    from: new Date() // Disable all dates up to specific date
                }
            }
        };
    },

    mounted() {
        loading: false;

        setTimeout(() => {
            axios
                .get("/api/reports/categories")
                .then(response => {
                    //console.log(response.data);
                    this.categories = response.data;
                    this.isCategoryFetched = false;
                })
                .catch(error => {
                    console.log(error);
                    Toast.fire({
                        icon: "error",
                        title:
                            "An error has occured while fetching category list !"
                    });
                });
        }, 2000);
    },
    methods: {
        submit() {
            this.errors = {};
            this.message = null;

            let loader = this.$loading.show({
                // Optional parameters
                container: this.fullPage ? null : this.$refs.formContainer,
                "is-full-page": true,
                loader: "dots",
                color: "red"
            });

            setTimeout(() => {
                axios
                    .post("/api/reports", this.fields)
                    .then(res => {
                        console.log(res.data);
                        loader.hide();

                        this.fields = {}; //Clear input fields.

                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text:
                                "Report will be sent to your domain email adress !"
                        }).then(() => {
                            window.location = "/home";
                        });
                    })
                    .catch(error => {
                        this.loaded = true;
                        loader.hide();

                        console.log(error);
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors || {};
                        } else if (error.response.status === 400) {
                            this.message = error.response.data.message || {};
                        } else {
                            Toast.fire({
                                icon: "error",
                                title: "An error has occured !"
                            });
                        }
                    });
            }, 2000);
        },

        onReportCategoryChange(e) {
            this.fields.reportCategory = e.target.value;
        }
    }
};
</script>
