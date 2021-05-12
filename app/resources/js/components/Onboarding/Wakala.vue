<template>
    <div class="col-8">
        <form @submit.prevent="submit" class="mb-3" id="loginForm" novalidate>
            <div class="form-group">
                <label class="text-bold">NIDA Number</label>
                <input
                    id="NIN"
                    name="NIN"
                    class="form-control"
                    type="text"
                    placeholder="Enter NIDA number"
                    v-model="fields.NIN"
                />
                <div v-if="errors && errors.NIN" class="text-danger">
                    {{ errors.NIN[0] }}
                </div>
            </div>
            <input
                type="hidden"
                name="fingerData"
                id="fingerData"
                v-model="fields.fingerData"
            />
            <div v-if="errors && errors.fingerData" class="text-danger">
                {{ errors.fingerData[0] }}
            </div>
            <input
                type="hidden"
                name="fingerCode"
                id="fingerCode"
                v-model="fields.fingerCode"
            />
            <div v-if="errors && errors.fingerCode" class="text-danger">
                {{ errors.fingerCode[0] }}
            </div>

            <div style="margin:6em">
                <table>
                    <tr valign="top">
                        <td>
                            <div class="backgroundA">
                                <input
                                    id="Radio1"
                                    name="rdoFinger"
                                    type="radio"
                                    value="L5"
                                    @change="onChange($event)"
                                    style="position:absolute; top: 49px; left: -9px;"
                                />
                                <input
                                    id="Radio2"
                                    type="radio"
                                    name="rdoFinger"
                                    value="L4"
                                    @change="onChange($event)"
                                    style="position:absolute; top: -4px; left: 35px; height: 20px;"
                                />
                                <input
                                    id="Radio3"
                                    type="radio"
                                    name="rdoFinger"
                                    value="L3"
                                    @change="onChange($event)"
                                    style="position:absolute; top: -17px; left: 95px;"
                                />
                                <input
                                    id="Radio4"
                                    type="radio"
                                    name="rdoFinger"
                                    value="L2"
                                    @change="onChange($event)"
                                    style="position:absolute; top: -1px; left: 164px;"
                                />
                                <input
                                    id="Radio5"
                                    type="radio"
                                    name="rdoFinger"
                                    value="L1"
                                    @change="onChange($event)"
                                    style="position:absolute; top: 125px; left: 219px;"
                                />
                                <input
                                    id="Radio6"
                                    type="radio"
                                    name="rdoFinger"
                                    value="R1"
                                    @change="onChange($event)"
                                    style="position:absolute; top: 125px; left: 259px; width: 20px;"
                                />
                                <input
                                    id="Radio7"
                                    type="radio"
                                    name="rdoFinger"
                                    value="R2"
                                    @change="onChange($event)"
                                    style="position:absolute; top: -1px; left: 315px;"
                                />
                                <input
                                    id="Radio8"
                                    type="radio"
                                    name="rdoFinger"
                                    value="R3"
                                    @change="onChange($event)"
                                    style="position:absolute; top: -17px; left: 381px;"
                                />
                                <input
                                    id="Radio9"
                                    type="radio"
                                    name="rdoFinger"
                                    value="R4"
                                    @change="onChange($event)"
                                    style="position:absolute; top: 0px; left: 446px;"
                                />
                                <input
                                    id="Radio10"
                                    type="radio"
                                    name="rdoFinger"
                                    value="R5"
                                    @change="onChange($event)"
                                    style="position:absolute; top: 45px; left: 485px; height: 20px;"
                                />
                                <div
                                    id="lblCapture"
                                    style="position:absolute; top: 200px; left: 218px; "
                                >
                                    <b>{{ selectedFinger }}</b>
                                </div>
                                <input
                                    id="Button1"
                                    type="button"
                                    value="Capture Fingerprint"
                                    class="btn btn-danger"
                                    v-on:click="capturePrint"
                                    style="position:relative; top: 229px; left: 190px;"
                                />
                            </div>
                        </td>
                        <td style="padding:10px">
                            <div class="row">
                                <div
                                    class="col-sm-12"
                                    style="margin-bottom:10px;"
                                >
                                    <img
                                        v-bind:src="FingerImage"
                                        style="height:130px; min-width:140px; border:solid 1px #CCCCCC;"
                                    />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <input
                                        id="Button1"
                                        type="button"
                                        value="Reset Fingerprint"
                                        class="btn btn-primary"
                                        onclick="ResetCaptureImage()"
                                    />
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- <child-component> </child-component> -->

            <button
                id="sendAggregatorNIDA"
                type="submit"
                class="btn btn-lg btn-primary "
            >
                <span class="fa fa-save"></span> Proceed
            </button>
        </form>
    </div>
</template>

<script>
import ChildComponent from "../FormHelper.vue";

export default {
    components: {
        ChildComponent
    },
    data() {
        return {
            fields: {},
            errors: {},
            success: false,
            loaded: true,
            loading: true,
            message: null,
            selectedFinger: "Select Finger",
            FingerImage: null
        };
    },
    mounted() {
        loading: false;
    },
    methods: {
        submit() {
            axios
                .post("/api/aggregator/onboard", this.fields)
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    this.loaded = true;

                    console.log(error);
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                    } else if (error.response.status === 400) {
                        this.message = error.response.data.message;
                    }
                });
        },
        capturePrint() {
            if (!this.fields.fingerCode) return;

            axios
                .get("http://localhost:2019/")
                .then(response => {
                    //console.log(response.data);
                    this.fields.fingerData = response.data;
                    this.FingerImage = "data:image/png;base64," + response.data;
                })
                .catch(error => {
                    this.loaded = true;

                    console.log(error);
                    // if (error.response.status === 422) {
                    //     this.errors = error.response.data.errors || {};
                    // } else if (error.response.status === 400) {
                    //     this.message = error.response.data.message;
                    // }
                });
        },
        onChange(event) {
            this.fields.fingerCode = event.target.value;
            console.log(event.target.value);

            switch (event.target.value) {
                case "R5":
                    this.selectedFinger = "Right Little";
                    break;
                case "R4":
                    this.selectedFinger = "Right Ring";
                    break;
                case "R3":
                    this.selectedFinger = "Right Middle";
                    break;
                case "R2":
                    this.selectedFinger = "Right Index";
                    break;
                case "R1":
                    this.selectedFinger = "Right Thumb";
                    break;
                case "L1":
                    this.selectedFinger = "Left Thumb";
                    break;
                case "L2":
                    this.selectedFinger = "Left Index";
                    break;
                case "L3":
                    this.selectedFinger = "Left Middle";
                    break;
                case "L4":
                    this.selectedFinger = "Left Ring";
                    break;
                case "L5":
                    this.selectedFinger = "Left Little";
                    break;
                default:
                    this.selectedFinger = null;
            }
        }
    }
};
</script>
