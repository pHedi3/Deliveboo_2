<template>
  <div class="back">
    <div
      class="loading"
      v-show="loadingCourse && loadingRestaurant && loadingDish"
    >
      caricamento...
    </div>
    <div v-show="!loadingCourse && !loadingRestaurant && !loadingDish">
      <div class="mymodal d-md-none p-1" v-show="flagModal">
        <div class="course">
          <div class="d-flex justify-content-between">
            <h1>carrello</h1>
            <button @click="flagModal = !flagModal">
              <i class="fas fa-sort-down"></i>
            </button>
          </div>
          <div v-for="item in cart" :key="item.id">
            {{ item.name }}
          </div>

          <!-- to do fare la parte della gestione delle quantità -->
        </div>
      </div>
      <div class="mymodal p-1" v-show="flagCheck && checkPay">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <div class="course">
                <div class="d-flex justify-content-between">
                  <h1>Completa l'ordine</h1>
                  <button @click="flagCheck = !flagCheck">
                    <i class="fas fa-sort-down"></i>
                  </button>
                </div>

                <div v-for="item in cart" :key="item.id">
                  {{ item.name }}
                </div>
                <div>
                  <label for="name">inserisci nome</label>
                  <input type="text" id="name" v-model="name" />
                </div>
                <div>
                  <label for="surname">inserisci cognome</label>
                  <input type="text" id="surname" v-model="surname" />
                </div>
                <div>
                  <label for="address">inserisci indirizzo</label>
                  <input type="text" id="address" v-model="address" />
                </div>
                <div>
                  <label for="phone">inserisci numero</label>
                  <input type="text" id="phone" v-model="phone" />
                </div>
                <div>
                  <label for="email">inserisci email</label>
                  <input type="text" id="email" v-model="email" />
                </div>
                <div>
                  <label for="discount">inserisci discount</label>
                  <input type="text" id="discount" v-model="discount" />
                </div>
                <div>
                  <label for="notes">inserisci note</label>
                  <input type="text" id="notes" v-model="notes" />
                </div>
                <button @click="getToken">prossimo passo</button>

                <h4>Totale: {{ totalPrice }}</h4>
                <div id="dropin-container"></div>
                <button
                  id="submit-button"
                  class="button button--small button--green"
                >
                  Purchase
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row p-2">
          <div class="col-6 col-md-12 p-2">
            <!--CARD RISTORANTE-->
            <div class="mycard">
              <img src="/img/restaurant.jpg" alt="" />
              <div class="inner-card">
                <div>
                  <h4>{{ restaurant.name }}</h4>
                  <h5 v-for="element in restaurant.category" :key="element.id">
                    {{ element.name }}
                  </h5>
                  <h6>{{ restaurant.address }}</h6>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6 d-md-none">
            <div class="course" @click="flagModal = !flagModal">
              <h1>carrello</h1>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-12">
            <div class="course" v-for="item in course" :key="item.id">
              <div class="d-flex justify-content-between">
                <h1>{{ item.name }}</h1>
                <button @click="showid = item.id">
                  <i class="fas fa-sort-down"></i>
                </button>
              </div>

              <div :class="item.name">
                <!--CARD PIATTO-->
                <div
                  class="dish"
                  v-for="element in dish"
                  :key="element.id"
                  v-show="item.name == element.course.name && showid == item.id"
                >
                  <div class="inner-dish-left">
                    <div>
                      <h4>{{ element.name }}</h4>
                    </div>
                    <div>
                      <h6>{{ element.price }}€</h6>
                    </div>
                    <hr />
                  </div>
                  <div class="inner-dish-right">
                    <div class="add">
                      <button @click="add(element)">
                        <i class="fas fa-plus"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-6 d-md-block d-none">
            <div class="course">
              <h1>carrello</h1>
              <div v-for="item in cart" :key="item.id">
                <span>{{ item.name }}</span
                ><button @click="remove(item)">
                  <i class="fas fa-times"></i>
                </button>
              </div>
              <div>
                <h4>Totale: {{ totalPrice }}€</h4>
              </div>
              <button @click="flagCheck = !flagCheck">completa l'ordine</button>
              <div id="dropin-container"></div>
              <button
                id="submit-button"
                class="button button--small button--green"
              >
                Purchase
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="risultato" class="d-none"></div>
  </div>
</template>

<script>
import Vue from "vue";
export default {
  data() {
    return {
      restaurant: {},
      dish: [],
      course: [],
      cart: [],
      showid: 0,
      flagModal: false,
      flagCheck: false,
      token: "",
      loadingCourse: true,
      loadingDish: true,
      loadingRestaurant: true,
      orderComplit: false,
      name: "",
      surname: "",
      address: "",
      phone: "",
      email: "",
      discount: "",
      notes: "",
      text: "",
      paid: false,
      sendJson: null,
    };
  },
  props: {
    id: Number,
  },
  created() {
    console.log("Component mounted.");
    this.getRestaurant();
    this.getDish();
    this.getCourse();
  },
  computed: {
    totalPrice() {
      var totalPrice = 0;
      this.cart.forEach((dish) => {
        totalPrice += dish.price;
      });
      return totalPrice.toFixed(2);
    },
    checkPay() {
      var text = document.getElementById("risultato").textContent;
      if (text == "transizione avvenuta") {
        return false;
      }
      return true;
    },
  },
  mounted() {
    if (JSON.parse(localStorage.getItem("storeCart")) != null) {
      this.cart = JSON.parse(localStorage.getItem("storeCart"));
      if (this.cart[0].restaurant.id != this.id) {
        this.cart = [];
      }
    } else {
      this.cart = [];
    }
  },
  methods: {
    getRestaurant() {
      axios.get("/api/restaurants/" + this.id).then((response) => {
        console.log(response.data.data);
        this.restaurant = response.data.data;
        this.loadingRestaurant = false;
      });
    },
    getDish() {
      axios.get("/api/dishes/" + this.id).then((response) => {
        console.log(response.data.data);
        this.dish = response.data.data;
        this.loadingDish = false;
      });
    },
    getCourse() {
      axios.get("/api/courses").then((response) => {
        console.log(response.data.data);
        this.course = response.data;
        this.loadingCourse = false;
      });
    },
    getToken() {
      this.myJson();
      axios.get("/api/pay").then((response) => {
        console.log(response.data.data);
        this.token = response.data.token;
        var button = document.querySelector("#submit-button");
        var token = this.token;
        let cart = this.cart;
        var order = this.sendJson;
        braintree.dropin.create(
          {
            authorization: this.token,
            selector: "#dropin-container",
          },
          function (err, instance) {
            button.addEventListener("click", function () {
              instance.requestPaymentMethod(function (err, payload) {
                axios
                  .post("/api/sendpay", {
                    token: payload.nonce,
                    cart: cart,
                  })
                  .then((response) => {
                    console.log(response.data);
                    if (response.data.success) {
                      axios.post("/api/orders", order).then((response) => {
                        console.log(response.data.data);
                        document.getElementById("risultato").innerHTML =
                          "transizione avvenuta";
                      });
                    }
                  });
              });
            });
          }
        );
      });
    },
    add(element) {
      this.cart.push(element);
      this.saveCart();
      console.log(this.myJson); //to do, non vedere i multipli
    },

    remove(item) {
      let itemId = this.cart.indexOf(item);
      this.cart.splice(itemId, 1);
      this.saveCart();
    },
    saveCart() {
      localStorage.setItem("storeCart", JSON.stringify(this.cart));
    },
    myJson() {
      this.sendJson = {
        name: this.name,
        surname: this.surname,
        address: this.address,
        email: this.email,
        phone: this.phone,
        price: this.totalPrice,
        status: "paid",
        discount: this.discount,
        notes: this.notes,
        dish: this.cart,
      };
    },
  },
};
</script>

<style lang="scss" scoped>
@import "../../sass/app.scss";
.mycard {
  background-color: rgba($color: #ffffff, $alpha: 0.8);
  height: 150px;
  overflow: hidden;
  position: relative;
  border-radius: 12px;
  padding: 8px;

  img {
    width: 100%;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }
  h5,
  h6 {
    font-weight: 400;
    text-align: center;
    color: #555;
  }
  .inner-card {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: rgba($color: #000, $alpha: 0.6);
    height: 100%;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    h5,
    h6 {
      color: white;
    }
  }

  h4 {
    margin-top: 8px;
    font-weight: 900;
    text-align: center;
  }
}

.back {
  background-color: $background;
  .loading {
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    font-size: 16px;
    height: 100px;
  }
  .mymodal {
    position: sticky;
    top: 0;
    z-index: 1001;
    width: 100%;
    height: 100vh;
    background-color: rgba($color: #0000, $alpha: 0.8);
  }
  .course {
    background-color: rgba($color: #ffffff, $alpha: 0.8);
    border-radius: 12px;
    padding: 8px;
    margin-top: 12px;
    .dish {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    button {
      background-color: $background2;
      color: $main-title;
      border: $background2;

      &:hover,
      &:active,
      &:visited,
      &:focus {
        background-color: $background2 !important;
        color: $main-title !important;
        border-color: $main-title !important;
      }

      &:active,
      &:focus,
      &:visited {
        box-shadow: 0 0 2px 2px $main-title !important;
      }
    }
  }
}
</style>
