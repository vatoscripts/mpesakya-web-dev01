<template>
    <div class="content-wrapper">
        <h4 class="content-heading">
            <div>
                M-pesa KYA Portal
                <p class="lead mt-2">
                    Wakala List with Verification Status for this week
                </p>
            </div>
        </h4>
        <div class="vld-parent" ref="formContainer">
            <div class="clearfix"></div>
            <div
                v-show="message"
                class="alert alert-warning alert-block mt-1  text-center"
            >
                <!-- <button type="button" class="close" data-dismiss="alert">
                    ×
                </button> -->
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
                        "Created Date",
                        "Status"
                    ]
                ],
                header: "row",
                border: true,
                stripe: true,
                pagination: true,
                pageSize: 25,

                columnWidth: [
                    { column: 0, width: "20%" },
                    { column: 1, width: "20%" },
                    { column: 2, width: "8%" },
                    { column: 5, width: "20%" }
                ]
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
                .get("/api/wakala/verification-status")
                .then(response => {
                    let items = response.data;
                    if (items.length > 0) {
                        items.forEach(el => {
                            this.params.data.push([
                                el.MpesaContactName,
                                el.OrganizationName,
                                el.Shortcode,
                                el.MpesaBusinessGroup,

                                el.CreatedDate,
                                el.VerificationStatus
                            ]);
                        });
                    } else {
                        this.message = "No avaliable wakala !";
                    }

                    loader.hide();
                })
                .catch(error => {
                    console.log(error);
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
