<template>
  <v-app>
    <v-main>
      <div class="d-flex justify-content-center full-height error-content">
        <div class="align-self-center">
          <v-row>
            <v-col  class="pa-0">
              <span class="error_code">
                401
              </span>
              <span class="error_error_message">
                Unauthorize
              </span>
            </v-col>
          </v-row>
          <v-row >
            <v-col  class="pa-0">
              <v-btn class="mx-2" text color="blue" link @click="$router.go(-1)"> Back </v-btn>
              <v-btn text color="blue" link to="/" > Home Page </v-btn>
            </v-col>
          </v-row>
        </div>
      </div>
    </v-main>
  </v-app>
</template>

<style>
    .error-content {
      background-color: #fff;
      color: #636b6f;
      font-family: 'Nunito', sans-serif;
      font-weight: 100;
      height: 100vh;
      margin: 0;
    }
    .full-height {
      height: 100vh;
    }

    .flex-center {
      align-items: center;
      display: flex;
      justify-content: center;
    }

    .position-ref {
      position: relative;
    }

    .error_code {
      border-right: 2px solid;
      font-size: 30px;
      padding: 0 15px 0 15px;
      text-align: center;
    }

    .error_error_message {
      font-size: 30px;
      text-align: center;
      padding: 7px 0 0 15px;
    }

    .btn-back-home {
      font-size: 15px;
      padding: 5px 0 0 0;
      text-align: center;
    }
    .btn-home {
      font-size: 15px;
      padding: 5px 0 0 0;
      text-align: center;
    }

  </style>