<template>
    <div class="content-wrapper">
        <h4 class="content-heading">
            <div>
                M-pesa KYA Portal
                <p class="lead mt-2">Approved Wakala List</p>
            </div>
        </h4>
        <div class="vld-parent" ref="formContainer">
            <div class="clearfix"></div>
            <div
                v-show="message"
                class="alert alert-warning alert-block mt-1 text-center"
            >
                <span class="h3">{{ message }}</span>
            </div>
            <div class="table-responsive" v-show="!message">
                <vue-table-dynamic :params="params" ref="table">
                </vue-table-dynamic>
            </div>
        </div>
    </div>
</template>

<script>
import VueTableDynamic from "vue-table-dynamic";

export default {
    data() {
        return {
            wakalas: "",
            fields: {},
            message: "",
            agents: null,
            params: {
                data: [
                    [
                        "Contact Name",
                        "Business Name",
                        "Short Code",
                        "Business Group",
                        "Approved Date",
                        "M-pesa Msisdn"
                    ]
                ],
                header: "row",
                border: true,
                stripe: true,
                pagination: true,
                pageSize: 25,
                sort: [0, 1, 2, 3, 4]
                // pageSizes: [5, 10, 20, 50]
            }
        };
    },
    mounted() {
        let loader = this.$loading.show({
            // Optional parameters
            container: this.fullPage ? null : this.$refs.formContainer,
            "is-full-page": true,
            loader: "dots",
            color: "red"
        });

        setTimeout(() => {
            axios
                .get("/api/wakala/approved")
                .then(response => {
                    let items = response.data;

                    if (items.length > 0) {
                        items.forEach(el => {
                            this.params.data.push([
                                el.MpesaContactName,
                                el.OrganizationName,
                                el.Shortcode,
                                el.MpesaBusinessGroup,
                                el.VerifiedDate,
                                el.MpesaMSISDN
                            ]);
                        });
                    } else {
                        this.message = "No avaliable approved wakala !";
                    }

                    loader.hide();
                })
                .catch(error => {
                    loader.hide();
                    Toast.fire({
                        icon: "error",
                        title: "An error occured while fetching wakala "
                    });
                });
        }, 2000);
    },

    components: { VueTableDynamic }
};
</script>
