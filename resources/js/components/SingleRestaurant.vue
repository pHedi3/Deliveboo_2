<template>
    <div class="back">
        <div class="mymodal d-md-none p-1" v-show="flagModal">
            <div class="course">
                <div class="d-flex justify-content-between">
                     <h1>carrello</h1>
                    <button @click="flagModal =!flagModal"><i class="fas fa-sort-down"></i></button>
                </div>
                
                <div v-for="item in cart" :key="item.id">
                     {{item.name}}
                </div>
            </div>
            
        </div>
        <div class="container">
            <div class="row p-2">
                    <div class="col-6 col-md-12 p-2"> <!--CARD RISTORANTE-->
                        <div class="mycard">
                            <img src="/img/restaurant.jpg" alt="">
                            <div class="inner-card">
                                <div>
                                     <h4>{{restaurant.name}}</h4>
                                     <h5 v-for="element in restaurant.category" :key="element.id">{{element.name}}</h5>
                                    <h6>{{restaurant.address}}</h6>
                                </div>
                               
                            </div>  
                        </div>
                    </div>
                    <div class="col-6 d-md-none">
                        <div class="course" @click="flagModal =!flagModal">
                             <h1>carrello</h1>
                        </div>
                       
                    </div>
                    <div class="col-lg-6 col-md-6 col-12"> 
                        <div class="course" v-for="item in course" :key="item.id">
                            <div class="d-flex justify-content-between">
                                 <h1>{{item.name}}</h1>
                                <button @click="showid = item.id"><i class="fas fa-sort-down"></i></button>
                            </div>
                           
                            <div v-show="item.name"> <!--CARD PIATTO-->
                                <div class="dish" v-for="element in dish" :key="element.id"
                                  v-show="(item.name == element.course.name) && (showid == item.id)">
                                    <div class="inner-dish-left">
                                        <div><h4>{{element.name}}</h4> </div>
                                        <div><h6>{{element.price}}€</h6></div>
                                        <hr>
                                    </div>  
                                    <div class="inner-dish-right">
                                        <div class="add">
                                            <button @click="add(element)"><i class="fas fa-plus"></i></button>
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
                              <span>{{item.name}}</span><button @click="remove(item)"><i class="fas fa-times"></i></button>   
                            </div>
                            <div>
                              <h4>Totale: {{total}}€</h4>
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
      restaurant: {},
      dish: [],
      course: [],
      cart: [],
      showid: 0,
      flagModal: false  

    };
  },
  props: {
      id: Number
},
mounted() {
      if (localStorage.getItem('stroreCart') != []) {
       this.cart = JSON.parse(localStorage.getItem('storeCart'))
        if (this.cart[0].restaurant.id != this.id){
            this.cart = []
        }
    }
},
  created() {
    console.log("Component mounted.");
    this.getRestaurant()
    this.getDish()
    this.getCourse()
    
  
        
  },
  computed: {
     total() {
    var sum = 0;
    this.cart.forEach(e => {
        sum += e.price;
    });
    return sum.toFixed(2);
    }
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
        this.cart.push(element)
        this.saveCart();            //to do, non vedere i multipli
    },
    remove(item) {
        let itemId = this.cart.indexOf(item)
        this.cart.splice(itemId, 1)
        this.saveCart();
    },
    saveCart() {
        localStorage.setItem('storeCart', JSON.stringify(this.cart))
    }
  },

};
</script>

<style lang="scss" scoped>
@import "../../sass/app.scss";
    .mycard {
        background-color: rgba($color: #ffffff, $alpha: .8);
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
        h5, h6 {
            font-weight: 400;
            text-align: center;
            color: #555;
        }
        .inner-card{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%); 
            background-color: rgba($color: #000, $alpha: .6);  
            height: 100%;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            h5, h6{
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
    .mymodal{
        position: fixed;
        z-index: 1001;
        width: 100%;
        height: 100vh;
        background-color: rgba($color: #0000, $alpha: .8);
       
        
    }
    .course{
        background-color: rgba($color: #ffffff, $alpha: .8);
        border-radius: 12px;
        padding: 8px;
        margin-top: 12px;
        .dish{
            display:flex;
            justify-content: space-between;
            align-items: center;   
            
        }
       
            
        button {
              background-color: $background2;
               color: $main-title;
               border: $background2;
    

            &:hover , &:active , &:visited , &:focus{
                background-color: $background2 !important;
                color: $main-title !important;
                border-color: $main-title !important;
            }

            &:active , &:focus, &:visited{
                box-shadow: 0 0 2px 2px $main-title !important;
                
            }
        }
    }
}

</style>
