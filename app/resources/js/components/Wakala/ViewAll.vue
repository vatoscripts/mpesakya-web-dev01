<template>
    <div class="content-wrapper">
        <h4 class="content-heading">
            <div>
                M-pesa KYA Portal
                <p class="lead mt-2">Onboarded Wakala List</p>
            </div>
        </h4>
        <div class="vld-parent" ref="formContainer">
            <div
                v-show="errorMessage"
                class="alert alert-warning alert-block mt-1 text-center"
            >
                <span class="h3">{{ errorMessage }}</span>
            </div>

            <div class="table-responsive" v-show="!errorMessage">
                <vue-table-dynamic :params="params" ref="table">
                </vue-table-dynamic>
            </div>
        </div>
    </div>
</template>

<script>
import VueTableDynamic from "vue-table-dynamic";

export default {
    components: { VueTableDynamic },
    data() {
        return {
            wakala: "",
            wakalas: null,
            fields: {},
            errors: {},
            success: false,
            loaded: true,
            loading: true,
            message: null,
            errorMessage: "",
            params: {
                data: [
                    [
                        "Business Name",
                        "Category",
                        "Short Code",
                        "Created Date",
                        "M-pesa Msisdn"
                    ]
                ],
                header: "row",
                border: true,
                stripe: true,
                pagination: true,
                pageSize: 30,
                sort: [0, 1, 2, 3, 4]
                // pageSizes: [5, 10, 20, 50]
            }
        };
    },
    mounted() {
        this.getlist();
        loading: false;
    },
    methods: {
        getlist() {
            let loader = this.$loading.show({
                // Optional parameters
                container: this.fullPage ? null : this.$refs.formContainer,
                "is-full-page": true,
                loader: "dots",
                color: "red"
            });

            setTimeout(() => {
                axios
                    .get("/api/wakala/all")
                    .then(response => {
                        let items = response.data;

                        if (items.length > 0) {
                            items.forEach(el => {
                                this.params.data.push([
                                    el.OrganizationName,
                                    el.Category,
                                    el.Shortcode,
                                    el.CreatedDate,
                                    el.MpesaMSISDN
                                ]);
                            });
                        } else {
                            this.errorMessage =
                                "No avaliable onboarded wakala !";
                        }

                        loader.hide();
                    })
                    .catch(error => {
                        loader.hide();
                        this.errorMessage = error.response.data.message;
                    });
            }, 2000);
        }
    }
};
</script>
