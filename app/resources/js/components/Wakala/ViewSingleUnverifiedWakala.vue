<template>
    <div class="content-wrapper">
        <h4 class="content-heading">
            <div>
                M-pesa KYA Portal
                <p class="lead mt-2">Wakala Details</p>
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
            <div class="row">
                <div class="col-lg-4">
                    <div class="card card-default">
                        <div class="card-body text-center">
                            <div class="py-4">
                                <img
                                    class="img-fluid rounded-circle img-thumbnail"
                                    :src="
                                        'data:image/png;base64,' + wakala.Photo
                                    "
                                    alt="Contact"
                                />
                            </div>
                            <h3 class="m-0 text-bold">{{ wakala.FullName }}</h3>
                            <div class="my-3">
                                <p>Created on : {{ wakala.CreatedDate }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card card-default d-none d-lg-block">
                        <div class="card-header">
                            <div class="text-bold card-title text-center">
                                Attachments
                            </div>
                        </div>
                        <div class="card-body">
                            <a
                                v-if="showBrela"
                                class="mb-2 text-info d-flex align-items-center link-unstyled"
                                v-show="brela"
                                :href="
                                    'data:application/jpg;base64,' +
                                        wakala.BrelaCertificate
                                "
                                :download="
                                    wakala.BusinessName +
                                        '-BrelaCertificate.jpg'
                                "
                                ><span
                                    ><em
                                        class="far fa-file fa-fw mr-2 text-inverse"
                                    ></em
                                    ><span>BRELA File</span></span
                                ><em
                                    class="ml-auto fa fa-download fa-fw text-info"
                                ></em></a
                            ><a
                                class="mb-2 text-info d-flex align-items-center link-unstyled"
                                :href="
                                    'data:application/jpg;base64,' +
                                        wakala.BusinessLicenceDoc
                                "
                                :download="
                                    wakala.BusinessName +
                                        '-BusinessLicenceDoc.jpg'
                                "
                                ><span
                                    ><em
                                        class="far fa-file fa-fw mr-2 text-inverse"
                                    ></em
                                    ><span>Business Licence File</span></span
                                ><em
                                    class="ml-auto fa fa-download fa-fw text-info"
                                ></em></a
                            ><a
                                class="mb-2 text-info d-flex align-items-center link-unstyled"
                                :href="
                                    'data:application/jpg;base64,' +
                                        wakala.TINDoc
                                "
                                :download="
                                    wakala.BusinessName + '-TINLicence.jpg'
                                "
                                ><span
                                    ><em
                                        class="far fa-file fa-fw mr-2 text-inverse"
                                    ></em
                                    ><span>TIN Licence File</span></span
                                ><em
                                    class="ml-auto fa fa-download fa-fw text-info"
                                ></em
                            ></a>
                            <a
                                v-if="showMemart"
                                class="mb-2 text-info d-flex align-items-center link-unstyled"
                                :href="
                                    'data:application/jpg;base64,' +
                                        wakala.Memart
                                "
                                :download="wakala.BusinessName + '-Memart.jpg'"
                                ><span
                                    ><em
                                        class="far fa-file fa-fw mr-2 text-inverse"
                                    ></em
                                    ><span>Memart File</span></span
                                ><em
                                    class="ml-auto fa fa-download fa-fw text-info"
                                ></em
                            ></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card card-default">
                        <div class="card-header d-flex align-items-center">
                            <div class="d-flex justify-content-center col">
                                <div class="h4 m-0 text-center">
                                    Contact Information
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row py-4 justify-content-center">
                                <div class="col-12 col-sm-10">
                                    <form class="form-horizontal">
                                        <div class="form-group row">
                                            <label
                                                class="text-bold col-4 col-form-label text-right"
                                                for="inputContact1"
                                                >Business Name</label
                                            >
                                            <div class="col-8">
                                                <input
                                                    class="form-control"
                                                    id="inputContact1"
                                                    type="text"
                                                    placeholder=""
                                                    :value="
                                                        wakala.OrganizationName
                                                    "
                                                    readonly
                                                />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label
                                                class="text-bold col-4 col-form-label text-right"
                                                for="inputContact2"
                                                >Till Number</label
                                            >
                                            <div class="col-8">
                                                <input
                                                    class="form-control"
                                                    id="inputContact2"
                                                    type="email"
                                                    :value="wakala.TillNumber"
                                                    readonly
                                                />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label
                                                class="text-bold col-4 col-form-label text-right"
                                                for="inputContact3"
                                                >Short Code</label
                                            >
                                            <div class="col-8">
                                                <input
                                                    class="form-control"
                                                    id="inputContact3"
                                                    type="text"
                                                    :value="wakala.Shortcode"
                                                    readonly
                                                />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label
                                                class="text-bold col-4 col-form-label text-right"
                                                for="inputContact4"
                                                >Business Licence Number</label
                                            >
                                            <div class="col-8">
                                                <input
                                                    class="form-control"
                                                    id="inputContact4"
                                                    type="text"
                                                    :value="
                                                        wakala.BusinessLicenceNo
                                                    "
                                                    readonly
                                                />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label
                                                class="text-bold col-4 col-form-label text-right"
                                                for="inputContact5"
                                                >TIN Number</label
                                            >
                                            <div class="col-8">
                                                <input
                                                    class="form-control"
                                                    id="inputContact5"
                                                    type="text"
                                                    :value="wakala.TIN"
                                                    readonly
                                                />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label
                                                class="text-bold col-4 col-form-label text-right"
                                                for="inputContact6"
                                                >Mpesa Business Group</label
                                            >
                                            <div class="col-8">
                                                <input
                                                    class="form-control"
                                                    id="inputContact7"
                                                    type="text"
                                                    :value="
                                                        wakala.MpesaBusinessGroup
                                                    "
                                                    readonly
                                                />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label
                                                class="text-bold col-4 col-form-label text-right"
                                                for="inputContact7"
                                                >NIN</label
                                            >
                                            <div class="col-8">
                                                <input
                                                    class="form-control"
                                                    id="inputContact7"
                                                    type="text"
                                                    :value="wakala.NIN"
                                                    readonly
                                                />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label
                                                class="text-bold col-4 col-form-label text-right"
                                                for="inputContact8"
                                                >Mpesa MSISDN</label
                                            >
                                            <div class="col-8">
                                                <input
                                                    class="form-control"
                                                    id="inputContact8"
                                                    type="text"
                                                    :value="wakala.MpesaMSISDN"
                                                    readonly
                                                />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label
                                                class="text-bold col-4 col-form-label text-right"
                                                for="inputContact8"
                                                >Office MSISDN</label
                                            >
                                            <div class="col-8">
                                                <input
                                                    class="form-control"
                                                    id="inputContact8"
                                                    type="text"
                                                    :value="wakala.OfficeMSISDN"
                                                    readonly
                                                />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label
                                                class="text-bold col-4 col-form-label text-right"
                                                for="inputContact8"
                                                >Mpesa Contact Name</label
                                            >
                                            <div class="col-8">
                                                <input
                                                    class="form-control"
                                                    id="inputContact8"
                                                    type="text"
                                                    :value="
                                                        wakala.MpesaContactName
                                                    "
                                                    readonly
                                                />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label
                                                class="text-bold col-4 col-form-label text-right"
                                                for="inputContact8"
                                                >Mpesa Contact MSISDN</label
                                            >
                                            <div class="col-8">
                                                <input
                                                    class="form-control"
                                                    id="inputContact8"
                                                    type="text"
                                                    :value="
                                                        wakala.MpesaContactMSISDN
                                                    "
                                                    readonly
                                                />
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label
                                                class="text-bold col-4 col-form-label text-right"
                                                for="inputContact8"
                                                >Mpesa MSISDN</label
                                            >
                                            <div class="col-8">
                                                <input
                                                    class="form-control"
                                                    id="inputContact8"
                                                    type="text"
                                                    :value="wakala.MpesaMSISDN"
                                                    readonly
                                                />
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-4"></div>
                                            <div class="col-4">
                                                <a
                                                    class="btn btn-danger text-white"
                                                    data-toggle="modal"
                                                    data-target="#addNewRecruiter"
                                                >
                                                    <i
                                                        class="far fa-times-circle"
                                                    ></i>
                                                    Decline</a
                                                >
                                            </div>
                                            <div class="col-4">
                                                <a
                                                    class="btn btn-success text-white"
                                                    style="float: right"
                                                    @click="acceptWakala"
                                                >
                                                    <i
                                                        class="far fa-check-circle"
                                                    ></i>
                                                    Accept
                                                </a>
                                            </div>
                                        </div>
                                    </form>

                                    <!-- Modal -->

                                    <div
                                        class="modal fade"
                                        id="addNewRecruiter"
                                        tabindex="-1"
                                        role="dialog"
                                        aria-labelledby="addNewRecruiterTitle"
                                        aria-hidden="true"
                                    >
                                        <div
                                            class="modal-dialog modal-dialog-centered"
                                            role="document"
                                        >
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4
                                                        class="modal-title"
                                                        id="exampleModalLongTitle"
                                                    >
                                                        Rejection Reason
                                                    </h4>
                                                    <button
                                                        type="button"
                                                        class="close"
                                                        data-dismiss="modal"
                                                        aria-label="Close"
                                                    >
                                                        <span aria-hidden="true"
                                                            >&times;</span
                                                        >
                                                    </button>
                                                </div>
                                                <form
                                                    @submit.prevent="
                                                        declineWakala
                                                    "
                                                    class="mb-3"
                                                    id="loginForm"
                                                    novalidate
                                                >
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <textarea
                                                                name="rejectReason"
                                                                id="form7"
                                                                class="md-textarea form-control"
                                                                rows="3"
                                                                v-model="
                                                                    fields.RejectComment
                                                                "
                                                            ></textarea>
                                                            <div
                                                                v-if="
                                                                    errors &&
                                                                        errors.RejectComment
                                                                "
                                                                class="text-danger"
                                                            >
                                                                {{
                                                                    errors
                                                                        .RejectComment[0]
                                                                }}
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="modal-footer"
                                                        >
                                                            <button
                                                                type="button"
                                                                class="btn btn-danger"
                                                                data-dismiss="modal"
                                                            >
                                                                Close
                                                            </button>
                                                            <button
                                                                type="submit"
                                                                class="btn btn-primary"
                                                            >
                                                                Confirm
                                                                Rejection
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- End Modal -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            agentID: null,
            brela: false,
            wakalas: null,
            wakala: {},
            errors: {},
            fields: {},
            success: false,
            loaded: true,
            loading: true,
            message: null,
            reason: false,
            showBrela: false,
            showMemart: false
        };
    },
    created() {
        let loader = this.$loading.show({
            // Optional parameters
            container: this.fullPage ? null : this.$refs.formContainer,
            "is-full-page": true,
            loader: "dots",
            color: "red"
        });

        setTimeout(() => {
            this.wakala = JSON.parse(sessionStorage.getItem("agent"));

            console.log(this.wakala);

            if (this.wakala.MpesaBusinessGroup == "Limited Company") {
                this.showBrela = true;
                this.showMemart = true;
            } else if (
                this.wakala.MpesaBusinessGroup == "Individual With Businessname"
            ) {
                this.showBrela = true;
            } else {
                this.showBrela = false;
                this.showMemart = false;
            }

            loader.hide();
        }, 3000);
    },
    methods: {
        declineWakala() {
            if (this.loaded) {
                this.loaded = false;
                this.success = false;
                this.errors = {};
                this.message = null;

                let loader = this.$loading.show({
                    // Optional parameters
                    container: this.fullPage ? null : this.$refs.formContainer,
                    "is-full-page": true,
                    loader: "dots",
                    color: "red"
                });

                this.fields.MpesaAgentID = this.wakala.MpesaAgentID;
                this.fields.VerificationStatus = 3;

                axios
                    .post("/api/wakala/verify", this.fields)
                    .then(response => {
                        loader.hide();
                        this.fields = {}; //Clear input fields.
                        this.loaded = true;
                        this.success = true;

                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: response.data.message
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
                        } else {
                            this.message = error.response.data.message;
                        }
                    });
            }
        },
        acceptWakala() {
            if (this.loaded) {
                this.loaded = false;
                this.success = false;
                this.errors = {};
                this.message = null;

                this.fields.MpesaAgentID = this.wakala.MpesaAgentID;
                this.fields.VerificationStatus = 2;
                this.fields.RejectComment = null;
                axios
                    .post("/api/wakala/verify", this.fields)
                    .then(response => {
                        console.log(response.data);
                        this.fields = {}; //Clear input fields.
                        this.loaded = true;
                        this.success = true;

                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: response.data.message
                        }).then(() => {
                            window.location = "/home";
                        });
                    })
                    .catch(error => {
                        this.loaded = true;

                        console.log(error);
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors || {};
                        } else {
                            this.message = error.response.data.message;
                        }
                    });
            }
        }
    },
    beforeDestroy() {
        console.log(
            `At this point, watchers, child components, and event listeners have not been teared down yet.`
        );

        sessionStorage.removeItem("agent");
    }
};
</script>
