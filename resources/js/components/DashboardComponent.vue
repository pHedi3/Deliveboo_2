<template>
  <div class="bg">
    <div class="container">
      <div class="row">
        <!-- <div class="card-new col-12 col-md-6" @click="flegNewRestaurant = true">
        <div class="button-container">
          <p class="button-text">Add New Restaurant</p>
          <i class="icon-add fas fa-plus-square"></i>
        </div>
      </div> -->
        <button
          type="button"
          class="btn btn-primary button-login button-create-r"
          data-toggle="modal"
          data-target="#exampleModal"
        >
          Aggiungi un nuovo Ristorante
        </button>
        <div
          class="modal fade"
          id="exampleModal"
          tabindex="-1"
          aria-labelledby="exampleModalLabel"
          aria-hidden="true"
        >
          <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button
                  type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Close"
                >
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <ValidationErrors
                  :errors="validationErrors"
                  v-if="validationErrors"
                />
                <form>
                  <div class="form-group">
                    <label for="exampleInputEmail1"
                      >Inserisci Nome del Ristorante</label
                    >
                    <input
                      v-model="newResturantName"
                      type="text"
                      class="form-control"
                      id="exampleInputEmail1"
                      aria-describedby="emailHelp"
                    />
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1"
                      >Inserisci indirizzo del Ristorante</label
                    >
                    <input
                      v-model="newResturantAddress"
                      type="text"
                      class="form-control"
                      id="exampleInputEmail1"
                      aria-describedby="emailHelp"
                    />
                  </div>
                  <div
                    v-for="element in category"
                    :key="element.id"
                    class="form-group form-check-inline"
                  >
                    <input
                      type="checkbox"
                      :id="element.name"
                      :value="element.id"
                      v-model="checkedCategory"
                      class="form-check-input"
                    />
                    <label class="form-check-label" :for="element.name">{{
                      element.name
                    }}</label>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button
                  @click="postRestaurant"
                  class="btn btn-primary button-login"
                >
                  Crea Nuovo Ristorante
                </button>
                <button
                  type="button"
                  class="btn btn-secondary"
                  data-dismiss="modal"
                >
                  Close
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <br />
      <br />
      <div class="row">
        <RestaurantDashboardCard
          v-for="restaurant in restaurants"
          :key="restaurant.id"
          :name="restaurant.name"
          :address="restaurant.address"
          :category="restaurant.category"
          :img="restaurant.img"
          :rId="restaurant.id"
        />
        <!-- <div
        class="col-12 col-md-6"
        v-for="restaurant in restaurants"
        :key="restaurant.id"
      >
        <div class="box-restaurant">
          <img
            :src="restaurant.img"
            class="card-img-top"
            alt="picture-restaurant"
          />
          <div class="card-body">
            <h3 class="card-title">{{ restaurant.name }}</h3>
            <p class="card-text">{{ restaurant.address }}</p>
            <p class="card-text">{{ restaurant.category }}</p>
          </div>
        </div>
      </div> -->
      </div>
      <!-- <div class="back-form" v-if="flegNewRestaurant">
      <div class="form">
        <label for="name">Inserisci Nome del Ristorante</label>
        <input
          class="border-box-add"
          type="text"
          id="name"
          v-model="newResturantName"
        />
        <br />
        <label for="address">Inserisci Indirizzo del Ristorante</label>
        <input
          class="border-box-add"
          type="text"
          id="address"
          v-model="newResturantAddress"
        />
        <br />

        <div class="category-box">
          <div class="tags" v-for="element in category" :key="element.id">
            <input
              type="checkbox"
              :id="element.name"
              :value="element.id"
              v-model="checkedCategory"
            />
            <label :for="element.name">{{ element.name }}</label>
          </div>
        </div>
        <button
          class="btn btn-primary button-add-restaurant"
          @click="postRestaurant"
        >
          Crea Nuovo Ristorante
        </button>
      </div>
    </div> -->
    </div>
  </div>
</template>
<script>
import RestaurantDashboardCard from "./RestaurantDashboardCard.vue";
import ValidationErrors from "./ValidationErrors.vue";

export default {
  props: ["app"],
  components: { RestaurantDashboardCard, ValidationErrors },
  data() {
    return {
      restaurants: [],
      user_id: this.$userId,
      category: [],
      newResturantName: "",
      newResturantAddress: "",
      checkedCategory: [],
      flegNewRestaurant: false,
      validationErrors: "",
    };
  },
  mounted() {
    this.getRestaurant();
    this.getCategory();
  },
  methods: {
    getRestaurant() {
      axios.get("/api/userRestaurant/" + this.user_id).then((response) => {
        this.restaurants = response.data.data;
        console.log(this.restaurants);
      });
    },
    getCategory() {
      axios.get("/api/categories").then((response) => {
        this.category = response.data;
      });
    },
    postRestaurant() {
      axios
        .post("/api/restaurants", {
          name: this.newResturantName,
          address: this.newResturantAddress,
          category_id: this.checkedCategory,
          user_id: this.user_id,
        })
        .then((response) => {
          this.getRestaurant();
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.validationErrors = error.response.data.errors;
          }
        });
      this.flegNewRestaurant = false;
    },
    getDishes() {
      axios.get("/api/dishes/{id}" + this.restaurant_id).then((response) => {
        this.dishes = response.data.data;
        console.log(this.dishes);
      });
    },
  },
};
</script>
<style lang="scss" scoped>
@import "../../sass/app.scss";
.card-new {
  margin-top: 50px;
  border: 1px solid black;
  height: 100px;
  padding: 20px;
  text-align: center;
  .button-container {
    .icon-add {
      font-size: 20px;
    }
    .button-text {
      font-size: 15px;
      font-weight: bold;
    }
  }
}
.back-form {
  position: fixed;
  width: 100%;
  height: 100vh;
  top: 0;
  left: 0;
  background-color: rgba(0, 0, 0, 0.7);
  .form {
    padding: 10px;
    border-radius: 10px;
    background-color: white;
    border: 1px solid black;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    .category-box {
      display: flex;
      flex-wrap: wrap;
      .tags {
        border: 1px solid black;
        margin: 10px 5px;
        border-bottom: 1px solid black;
      }
    }
    .border-box-add {
      &:hover,
      &:active,
      &:focus,
      &:visited {
        box-shadow: 0 0 1px 1px #8e3b46 !important;
      }
    }
    .button-add-restaurant {
      background-color: #e1dd8f;
      border: #e1dd8f;
      color: #8e3b46;
      transition: none;
      &:hover,
      &:active,
      &:visited,
      &:focus {
        background-color: #e1dd8f !important;
        color: #8e3b46 !important;
        border-color: #8e3b46 !important;
      }
      &:active,
      &:focus,
      &:visited {
        box-shadow: 0 0 2px 2px #8e3b46 !important;
      }
    }
  }
}

.button-create-r {
  margin-top: 20px;
  font-weight: bold;
  height: 50px;
}

.bg {
  background-color: $background;
}
</style>