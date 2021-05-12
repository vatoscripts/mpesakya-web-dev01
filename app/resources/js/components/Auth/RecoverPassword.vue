<template>
    <div>
        <div class="clearfix"></div>
        <div v-if="message" class="alert alert-danger alert-block mt-1">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <span class="lead">{{ message }}</span>
        </div>
        <h4>
            <p class="text-center py-2 h6 text-bold">RECOVER PASSWORD</p>
        </h4>
        <form @submit.prevent="submit" class="mb-3" id="recover-password-form">
            <div class="form-group">
                <div class="input-group with-focus">
                    <input
                        class="form-control border-right-0"
                        name="inputpwdOld"
                        type="password"
                        placeholder="Old Password"
                        v-model="fields.inputpwdOld"
                    />
                    <div class="input-group-append">
                        <span
                            class="input-group-text text-muted bg-transparent border-left-0"
                        >
                            <em class="fa fa-lock"></em>
                        </span>
                    </div>
                </div>
                <div v-if="errors && errors.inputpwdOld" class="text-danger">
                    {{ errors.inputpwdOld[0] }}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group with-focus">
                    <input
                        class="form-control border-right-0"
                        name="inputpwdNew"
                        type="password"
                        placeholder="New Password"
                        v-model="fields.inputpwdNew"
                    />
                    <div class="input-group-append">
                        <span
                            class="input-group-text text-muted bg-transparent border-left-0"
                        >
                            <em class="fa fa-lock"></em>
                        </span>
                    </div>
                </div>
                <div v-if="errors && errors.inputpwdNew" class="text-danger">
                    {{ errors.inputpwdNew[0] }}
                </div>
            </div>
            <div class="form-group">
                <div class="input-group with-focus">
                    <input
                        class="form-control border-right-0"
                        name="inputpwdNewConfirm"
                        type="password"
                        placeholder="Repeat new password"
                        v-model="fields.inputpwdNewConfirm"
                    />
                    <div class="input-group-append">
                        <span
                            class="input-group-text text-muted bg-transparent border-left-0"
                        >
                            <em class="fa fa-lock"></em>
                        </span>
                    </div>
                </div>
                <div
                    v-if="errors && errors.inputpwdNewConfirm"
                    class="text-danger"
                >
                    {{ errors.inputpwdNewConfirm[0] }}
                </div>
            </div>

            <button class="btn btn-block btn-danger mt-3" type="submit">
                Save New Password
            </button>

            <div class="float-right">
                <a class="text-lg-right font-weight-bold" href="/"
                    >Back to Login</a
                >
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
            loading: true,
            message: null
        };
    },
    mounted() {
        loading: false;
    },
    methods: {
        submit() {
            let loader = this.$loading.show({
                // Optional parameters
                container: this.fullPage ? null : this.$refs.formContainer,
                "is-full-page": false,
                loader: "dots",
                color: "red",
            });
            if (this.loaded) {
                this.loaded = false;
                this.success = false;
                this.errors = {};
                this.message = null;
                axios
                    .post("/api/auth/recover-password", this.fields)
                    .then(response => {
                        loader.hide();
                        this.fields = {}; //Clear input fields.
                        this.loaded = true;
                        this.success = true;

                        Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: 'Password reset successful !'
                    }).then(() => {
                        window.location = "/login";
                    });


                    })
                    .catch(error => {
                        this.loaded = true;
                        loader.hide();

                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors || {};
                        } else if (error.response.status === 400) {
                            this.message = error.response.data.message;
                        }
                    });
            }
        }
    }
};
</script>
