<template>
    <div class="vld-parent" ref="formContainer">
        <div class="clearfix"></div>
        <div v-if="message" class="alert alert-danger text-center">
            <span class="lead">{{ message }}</span>
        </div>
        <form @submit.prevent="submit" class="mb-3" id="loginForm">
            <div class="form-group">
                <div class="input-group with-focus">
                    <input
                        name="name"
                        class="form-control border-right-0"
                        type="text"
                        placeholder="Enter username"
                        v-model="fields.name"
                        autocomplete="username"
                    />

                    <div class="input-group-append">
                        <span
                            class="input-group-text text-muted bg-transparent border-left-0"
                        >
                            <em class="fa fa-user"></em>
                        </span>
                    </div>
                </div>
                <div v-if="errors && errors.name" class="text-danger">
                    {{ errors.name[0] }}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group with-focus">
                    <input
                        name="password"
                        class="form-control border-right-0"
                        type="password"
                        placeholder="Enter password"
                        v-model="fields.password"
                        autocomplete="current-password"
                    />

                    <div class="input-group-append">
                        <span
                            class="input-group-text text-muted bg-transparent border-left-0"
                        >
                            <em class="fa fa-lock"></em>
                        </span>
                    </div>
                </div>
                <div v-if="errors && errors.password" class="text-danger">
                    {{ errors.password[0] }}
                </div>
            </div>
            <div class="checkbox c-checkbox mt-0">
                <label>
                    <input
                        type="checkbox"
                        name="terms"
                        v-model="fields.terms"
                    />
                    <span class="fa fa-check"></span> I agree with the
                    <a v-on:click="showTC" href="#" class="ml-1"
                        >Terms & Conditions</a
                    >
                </label>

                <div v-if="errors && errors.terms" class="text-danger">
                    {{ errors.terms[0] }}
                </div>
            </div>

            <button
                name="login"
                class="btn btn-block btn-danger mt-3"
                type="submit"
            >
                Login
            </button>
            <div class="clearfix">
                <div class="float-right">
                    <a
                        class="text-lg-right font-weight-bold"
                        href="forgot-password"
                        >Forgot your password ?</a
                    >
                </div>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            fields: {},
            errors: {},
            success: false,
            loaded: true,
            loading: false,
            message: null,
            checked: false
        };
    },

    created() {
        sessionStorage.clear();
    },

    methods: {
        submit() {
            let loader = this.$loading.show({
                // Optional parameters
                container: this.fullPage ? null : this.$refs.formContainer,
                "is-full-page": false,
                loader: "dots",
                color: "red"
            });

            if (this.loaded) {
                this.loaded = false;
                this.success = false;
                this.errors = {};
                this.message = null;

                axios
                    .post("/api/auth/login", this.fields)
                    .then(res => {
                        this.fields = {}; //Clear input fields.
                        this.loaded = true;
                        this.success = true;
                        this.loading = false;

                        loader.hide();

                        if (res.data.Response.ChangePassword === true) {
                            window.location = "/recover-password";
                            //this.$router.push({ name: "recover-password" });
                        } else {
                            window.location = "/otp";
                            //this.$router.push({ name: "otp" });
                            sessionStorage.setItem(
                                "name",
                                res.data.Response.UserName
                            );
                        }
                    })
                    .catch(error => {
                        this.loaded = true;
                        loader.hide();

                        if (error.response.status === 400) {
                            this.message = error.response.data.message || {};
                        } else if (error.response.status === 422) {
                            this.errors = error.response.data.errors || {};
                        } else {
                            Toast.fire({
                                icon: "error",
                                title: "An error has occured !"
                            });
                        }
                    });
            }
        },
        showTC() {
            var terms =
                "All that you transmit and/or access as well as " +
                "activity that you do in this system,may be intercepted, monitored, " +
                "disclosed and / or recorded by the company,to ensure compliance with " +
                "Companys Information Security Policy VTL - ITB - POL - 008 and establish the existence of facts.";

            Swal.fire({
                icon: "info",
                title: "Login Service Agreement",
                text: terms,
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,

                confirmButtonText: '<i class="fa fa-thumbs-up"></i> Agree !'
            }).then(function(isConfirm) {
                if (isConfirm) {
                    console.log("CONFIRMED");
                    this.fields.terms = true;
                }
            });
        },
        disableCB() {
            return (this.fields.terms.disabled = true);
        }
    }
};
</script>
