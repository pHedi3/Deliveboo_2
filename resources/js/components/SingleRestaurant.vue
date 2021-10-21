<template>
  <div class="back">
    <div
      class="loading"
      v-show="loadingCourse && loadingRestaurant && loadingDish"
    >
          <div class="spinner-border" role="status">
            <span class="visually-hidden"></span>
          </div>
    </div>
    <div id="risultatoP" class="d-none p-1">
        <div class="course">
          <h1>Pagamento riuscito</h1>
        <button @click="removeOk">
          ok
        </button>
        </div>
    </div>
    <div id="risultatoN" class="d-none p-1">
        <div class="course">
          <h1>Pagamento Fallito</h1>
        <button @click="removeBad">
          riprova
        </button>
        </div>
    </div>
    <div v-show="!loadingCourse && !loadingRestaurant && !loadingDish">
      <div class="mymodal d-md-none p-1" v-show="flagModal">
        <div class="course">
          <div class="d-flex justify-content-between">
            <h1>carrello</h1>
            <button class="button-icon" @click="flagModal = !flagModal">
              <i class="fas fa-sort-down"></i>
            </button>
          </div>
          <div class="element-cart" v-show="flagReload" v-for="(item, key, index) in cart" :key="index">
            <div>
              <span>{{ item.name }}</span>
              <span>{{ item.quantity }}</span>
            </div>
            <button class="button-icon" @click="remove(item)">
              <i class="fas fa-times"></i>
            </button>
          </div>
          <div>
            <h4 v-show="flagReload">Totale: {{ allPrice }}€</h4>
          </div>
          <button @click="flagCheck = !flagCheck; flagModal = !flagModal">completa l'ordine</button>

          <!-- to do fare la parte della gestione delle quantità -->
        </div>
      </div>
      <div class="mymodal p-1" v-show="flagCheck">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <div class="course">
                <div class="d-flex justify-content-between">
                  <h1>Completa l'ordine</h1>
                  <button class="button-icon" @click="flagCheck = !flagCheck; sendJson = {}; stepOne = true; stepTwo= false; stepThree= false">
                    <i class="fas fa-sort-down"></i>
                  </button>
                </div>
                <div class="order" v-show="stepOne">
                <div class="row align-items-center" v-show="flagReload" v-for="(item, key, index) in cart" :key="index">
                  <h4 class="col-6 ">{{ item.name }}</h4>
                  <div class="col-2 col-md-1">
                    <input type="number" v-model="item.quantity" @change="totalPrice()">
                  </div>
                  <div class="co-1 offset-1">
                    <button class=" button-icon" @click="remove(item)">
                      <i class="fas fa-times"></i>
                    </button>

                  </div>
                </div>
                  <h4>Totale: {{ allPrice }}€</h4>
                  <button @click="stepOne=false; stepTwo=true; totalPrice()">Prossimo passo</button>
                </div>
                <div class="error" v-show="stepTwo">
                    <h5 v-for="(error, index) in errorText" :key="index">{{error}}</h5>
                </div>
                <div class="input" v-show="stepTwo">
                  <div class="row align-items-center p-1">
                    <label class="col-3 col-lg-2" for="name"> nome</label>
                    <input class="col-8 col-lg-6" type="text" id="name" v-model="name" />
                  </div>
                  <div class="row align-items-center p-1">
                    <label class="col-3 col-lg-2" for="surname"> cognome</label>
                    <input class="col-8 col-lg-6" type="text" id="surname" v-model="surname" />
                  </div>
                  <div class="row align-items-center p-1">
                    <label class="col-3 col-lg-2" for="address"> indirizzo</label>
                    <input class="col-8 col-lg-6" type="text" id="address" v-model="address" />
                  </div>
                  <div class="row align-items-center p-1">
                    <label class="col-3 col-lg-2" for="phone"> numero</label>
                    <input class="col-8 col-lg-6" type="text" id="phone" v-model="phone" />
                  </div>
                  <div class="row align-items-center p-1">
                    <label class="col-3 col-lg-2" for="email"> email</label>
                    <input class="col-8 col-lg-6" type="text" id="email" v-model="email" />
                  </div>
                  <div class="row align-items-center p-1">
                    <label class="col-3 col-lg-2" for="discount"> discount</label>
                    <input class="col-8 col-lg-6" type="text" id="discount" v-model="discount" />
                  </div>
                  <div class="row align-items-center p-1">
                    <label class="col-3 col-lg-2" for="notes"> note</label>
                    <input class="col-8 col-lg-6" type="text" id="notes" v-model="notes" />
                  </div>
                  <button @click="myJson">prossimo passo</button>
                </div>
                <div class="pay" v-show="stepThree">
                  <h4 v-show="flagToken">Attendi..</h4>
                  <h4>Totale: {{ allPrice }}€</h4>
                  <div id="dropin-container"></div>
                  <button @click="stepThree=false; flagCheck= !flagCheck; cart = []; saveCart(); totalPrice() "
                    id="submit-button"
                    class="button button--small button--green"
                  >
                    Completa l'ordine
                  </button>

                </div>
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
            <div class="course special" @click="flagModal = !flagModal">
              <div class="center">
                <h1>carrello</h1>
                <div class="cartNumber">
                  {{cart.length}}
                </div>
                <i class="fas fa-shopping-cart"></i>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-12">
            <div class="course" v-for="item in course" :key="item.id">
              <div class="d-flex justify-content-between">
                <h1>{{ item.name }}</h1>
                <button class="button-icon" @click="takeId(item.id)">
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
                      <button class="button-icon" @click="add(element)">
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
              <div class="element-cart" v-show="flagReload" v-for="(item, key, index) in cart" :key="index">
                <div>
                  <span>{{ item.name }}</span>
                  <span>{{ item.quantity }}</span>
                </div>
                <button class="button-icon" @click="remove(item)">
                  <i class="fas fa-times"></i>
                </button>
              </div>
              <div>
                <h4 v-show="flagReload">Totale: {{ allPrice }}€</h4>
              </div>
              <button @click="flagCheck = !flagCheck">completa l'ordine</button>
            </div>
          </div>
        </div>
      </div>
    </div>
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
      errorText: [],
      allOk: true,
      stepThree: false,
      stepTwo: false,
      stepOne: true,
      flagToken: true,
      flagReload: true,
      allPrice: 0,
      text: ""

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
    
  },
  mounted() {
    if (JSON.parse(localStorage.getItem("storeCart")) != null) {
      this.cart = JSON.parse(localStorage.getItem("storeCart"));
      this.totalPrice()
      if (this.cart[0].restaurant.id != this.id) {
        this.cart = [];
      }
    } else {
      this.cart = [];
    }
  },
  methods: {
    takeId(id) {
      if (this.showid == id) {
        this.showid = 0
      } else {
        this.showid = id
      }
    },
    totalPrice() {
      this.allPrice = 0;
      let total = 0
      this.cart.forEach((dish) => {
        total += dish.price * dish.quantity;
      });
      this.allPrice = total.toFixed(2);
    },
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
      axios.get("/api/pay").then((response) => {
        console.log(response.data.data);
        this.token = response.data.token;
        var button = document.querySelector("#submit-button");
        var token = this.token;
        let cart = this.cart;
        var order = this.sendJson;
        this.flagToken = false;
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
                        document.getElementById("risultatoP").classList.add("ok");

                      });
                    } else {
                      document.getElementById("risultatoN").classList.add("bad");
                    }
                  });
              });
            });
          }
        );
      });
    },
    add(element) {
      this.flagReload = false
      this.flagReload = true
      if (this.cart.includes(element)) {
        let index = this.cart.indexOf(element)
        this.cart[index].quantity += 1
      } else {
        let dish = element
        dish.quantity = 1
        this.cart.push(dish);
      }
      this.saveCart();
      this.totalPrice()
    },

    remove(item) {
      let itemId = this.cart.indexOf(item);
      this.cart.splice(itemId, 1);
      this.saveCart();
      this.totalPrice()

    },
    saveCart() {
      localStorage.setItem("storeCart", JSON.stringify(this.cart));
    },
    removeOk() {
      document.getElementById("risultatoP").classList.remove("ok");
    },
    removeBad() {
      document.getElementById("risultatoN").classList.remove("bad");
    },
    myJson() {
      this.errorText = []
      if (this.name == "") {
        this.errorText.push('Devi inserire il nome')
        this.allOk  = false
      }
      if (this.surname == "") {
        this.errorText.push('Devi inserire il cognome')
        this.allOk  = false
      }
      if (this.address == "") {
        this.errorText.push('Devi inserire l\'indirizzo')
        this.allOk  = false
      }
      if (this.email == "") {
        this.errorText.push('Devi inserire il email')
        this.allOk  = false
      }
      if (this.phone == "") {
        this.errorText.push('Devi inserire il telefono')
        this.allOk  = false
      }
      if (!this.email.includes('@') && !this.email.includes('.')) {
        this.errorText.push('Devi inserire una email valida')
        this.allOk  = false
      }
      if (this.allOk) {
        this.stepTwo = false
        this.stepThree = true
        this.sendJson = {
          name: this.name,
          surname: this.surname,
          address: this.address,
          email: this.email,
          phone: this.phone,
          price: this.allPrice,
          status: "paid",
          discount: this.discount,
          notes: this.notes,
          dish: this.cart,
        };
        this.getToken()
      }
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
  .loading{
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
    padding-top: 12px;
  }
  .course {
    background-color: rgba($color: #ffffff, $alpha: 0.8);
    border-radius: 12px;
    padding: 8px;
    margin-bottom: 12px ;
    .order {
      input {
        width: 100%;
      }
    }
    &.special {
      height: calc(100% - 12px);
      display: flex;
      justify-content: center;
      align-items: center;
      .center {

        .cartNumber {
          display: inline-block;
          height: 20px;
          width: 20px;
          background-color: $background;
          border-radius: 50%;
          display: flex;
          justify-content: center;
          align-items: center;
          color: white;
        }
      }
    }
    .dish {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .element-cart {
      display: flex;
      margin: 8px 0;
      box-shadow: 0 0 3px 1px $background;
      justify-content: space-between;
      align-items: center;
      button {
        margin-right: 4px;
      }
      span {
        font-weight: bold;
        padding: 4px 0;
      }
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
.error {
  background-color: rgb(255, 113, 113);
  h5 {
    font-size: 14px;
    color: black;
    padding: 6px 12px;
    margin: 0;
    &:first-child {
      padding: 12px 12px 6px;
    }
    &:last-child {
      padding: 6px 12px 12px;
    }
  }
}
.button-icon {
    height: 20px;
    width: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.ok {
  display: block !important;
  position: sticky;
    top: 0;
    z-index: 1001;
    width: 100%;
    height: 100vh;
    background-color: rgba($color: #0000, $alpha: 0.8);
    text-align: center;
    .course {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }
}
  .bad {
  display: block !important;
  position: sticky;
    top: 0;
    z-index: 1001;
    width: 100%;
    height: 100vh;
    background-color: rgba($color: #0000, $alpha: 0.8);
    text-align: center;
    .course {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }
}
</style>
