<template>
  <div class="content-wrapper">
    <h4 class="content-heading">
      <div>
        M-pesa KYA Portal
        <p class="lead mt-2">Onboard Wakala: NIDA verification</p>
      </div>
    </h4>
    <div class="col-8 vld-parent" ref="formContainer">
      <div class="clearfix"></div>
      <div
        v-show="message"
        class="alert alert-warning alert-block mt-1 text-center"
      >
        <span class="h3">{{ message }}</span>
      </div>
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

        <input type="hidden" name="fingerData" id="fingerData" />
        <input type="hidden" name="fingerCode" id="fingerCode" />

        <div class="row">
          <div class="col-6">
            <div v-if="errors && errors.fingerCode" class="text-danger">
              {{ errors.fingerCode[0] }}
            </div>
          </div>
          <div class="col-6">
            <div v-if="errors && errors.fingerData" class="text-danger">
              {{ errors.fingerData[0] }}
            </div>
          </div>
        </div>

        <div style="margin: 6em">
          <table>
            <tr valign="top">
              <td>
                <div class="backgroundA">
                  <input
                    id="Radio1"
                    name="rdoFinger"
                    onchange="getFingerName(this)"
                    type="radio"
                    style="position: absolute; top: 49px; left: -9px"
                  />
                  <input
                    id="Radio2"
                    type="radio"
                    name="rdoFinger"
                    onchange="getFingerName(this)"
                    style="
                      position: absolute;
                      top: -4px;
                      left: 35px;
                      height: 20px;
                    "
                  />
                  <input
                    id="Radio3"
                    type="radio"
                    name="rdoFinger"
                    onchange="getFingerName(this)"
                    style="position: absolute; top: -17px; left: 95px"
                  />
                  <input
                    id="Radio4"
                    type="radio"
                    name="rdoFinger"
                    onchange="getFingerName(this)"
                    style="position: absolute; top: -1px; left: 164px"
                  />
                  <input
                    id="Radio5"
                    type="radio"
                    name="rdoFinger"
                    onchange="getFingerName(this)"
                    style="position: absolute; top: 125px; left: 219px"
                  />
                  <input
                    id="Radio6"
                    type="radio"
                    name="rdoFinger"
                    onchange="getFingerName(this)"
                    style="
                      position: absolute;
                      top: 125px;
                      left: 259px;
                      width: 20px;
                    "
                  />
                  <input
                    id="Radio7"
                    type="radio"
                    name="rdoFinger"
                    onchange="getFingerName(this)"
                    style="position: absolute; top: -1px; left: 315px"
                  />
                  <input
                    id="Radio8"
                    type="radio"
                    name="rdoFinger"
                    onchange="getFingerName(this)"
                    style="position: absolute; top: -17px; left: 381px"
                  />
                  <input
                    id="Radio9"
                    type="radio"
                    name="rdoFinger"
                    onchange="getFingerName(this)"
                    style="position: absolute; top: 0px; left: 446px"
                  />
                  <input
                    id="Radio10"
                    type="radio"
                    name="rdoFinger"
                    onchange="getFingerName(this)"
                    style="
                      position: absolute;
                      top: 45px;
                      left: 485px;
                      height: 20px;
                    "
                  />
                  <div
                    id="lblCapture"
                    style="position: absolute; top: 200px; left: 218px"
                  >
                    <b>Select Finger</b>
                  </div>
                  <input
                    id="Button1"
                    type="button"
                    value="Capture Fingerprint"
                    class="btn btn-danger"
                    onclick="Capture()"
                    style="position: relative; top: 229px; left: 190px"
                  />
                </div>
              </td>
              <td style="padding: 10px">
                <div class="row">
                  <div class="col-sm-12" style="margin-bottom: 10px">
                    <img
                      id="FingerImage"
                      src=" "
                      style="
                        height: 130px;
                        min-width: 140px;
                        border: solid 1px #cccccc;
                      "
                    />
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <input
                      id="Button1"
                      type="button"
                      value="Reset Fingerprint"
                      class="btn btn-default"
                      onclick="ResetCaptureImage()"
                    />
                  </div>
                </div>
              </td>
            </tr>
          </table>
        </div>

        <button
          id="sendAggregatorNIDA"
          type="submit"
          class="btn btn-lg btn-primary"
        >
          <em class="fa mr-2 fas fa-arrow-right"></em> Proceed
        </button>
      </form>
    </div>
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
      message: null,
      selectedFinger: "Select Finger",
      FingerImage: null,
    };
  },
  mounted() {
    loading: false;
  },
  methods: {
    submit() {
      this.errors = {};
      this.message = null;

      let loader = this.$loading.show({
        // Optional parameters
        container: this.fullPage ? null : this.$refs.formContainer,
        "is-full-page": false,
        loader: "dots",
        color: "red",
      });

      this.fields.fingerData = document.querySelector(
        "input[name=fingerData]"
      ).value;
      this.fields.fingerCode = document.querySelector(
        "input[name=fingerCode]"
      ).value;

      axios
        .post("/api/wakala/onboard/first", this.fields)
        .then((response) => {
          console.log(response.data);
          loader.hide();
          this.$router.push({ name: "onboard-wakala-save" });
        })
        .catch((error) => {
          this.loaded = true;
          loader.hide();
          console.log(error);
          if (error.response.status === 422) {
            this.errors = error.response.data.errors || {};
          } else if (error.response.status === 400) {
            this.message = error.response.data.message;
          }
        });
    },
  },
};
</script>
