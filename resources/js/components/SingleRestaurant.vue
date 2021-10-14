<template>
<div class="back">
    <div class="container">
        <div class="row">
            <div class=" col-10 dish">
                <div v-for="item in course" :key="item.id">
                    <h1>{{item.name}}</h1>
                    <div v-for="element in dish" :key="element.id"
                    v-show="item.name == element.course.name">
                        {{element.name}} 
                        <button @click="add(element)">+</button><br>
                        {{element.price}}€
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="mycard">
                    <h4>{{restaurant.name}}</h4>
                    <h5 v-for="element in restaurant.category" :key="element.id">{{element.name}}</h5>
                    <h6>{{restaurant.address}}</h6>
                </div>
            </div>
            <div class="col-6">
                <h1>carrello</h1>
                <div v-for="item in cart" :key="item.id">
                    {{item.name}}
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
      restaurant: {},
      dish: [],
      course: [],
      cart: []

    };
  },
  props: {
      id: Number
},
  created() {
    console.log("Component mounted.");
    this.getRestaurant()
    this.getDish()
    this.getCourse()
  },
  methods: {
    getRestaurant() {
        axios.get("/api/restaurants/" + this.id).then((response) => {
            console.log(response.data.data);
            this.restaurant = response.data.data
        });
    },
    getDish() {
        axios.get("/api/dishes/" + this.id).then((response) => {
            console.log(response.data.data);
            this.dish = response.data.data
        });
    },
    getCourse() {
        axios.get("/api/courses").then((response) => {
            console.log(response.data.data);
            this.course = response.data
        });
    },
    add(element) {
        this.cart.push(element) //to do, non vedere i multipli
    }
  },
};
</script>

<style lang="scss" scoped>
@import "../../sass/app.scss";
    .mycard {
        background-color: rgba($color: #ffffff, $alpha: .8);
        border-radius: 12px;
        padding: 8px;
        img {
            width: 100%;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }
    h4 {
        margin-top: 8px;
        font-weight: 900;
    }
    h5, h6 {
        font-weight: 400;
    }
    h6 {
        color: #555;
        font-size: 12px;
    }
    }
    .bord {
        margin-bottom: 30px;
    }
    h5 {
        margin-right: 4px;
        display: inline-block;
    }

.back {
    background-color: $background;
}

</style>
