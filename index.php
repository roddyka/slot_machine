<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/phaser@3.15.1/dist/phaser-arcade-physics.min.js"></script>
</head>
<body>

    <script>
    var config = {
        type: Phaser.AUTO,
        width: 800,
        height: 600,
        physics: {
            default: 'arcade',
            arcade: {
                gravity: { y: 200 }
            }
        },
        scene: {
            preload: preload,
            create: create,
            update: update,
        },
    };

    const width = 800;
    const height = 600;
    const x = width * 0.5;
    const y = height * 0.5;
  
    var game = new Phaser.Game(config);
    var spin_button;
    var spin_button_clicked = false;

    let insertedCoins;
    let buyButton;
    let coin;

    let insertCoinText;

  //   let fruits_carrosel =[
  //     [{'fruit' :'banana' ,
  //       'x' : '200',
  //       'y' : '-300'
  //     },
  //     {'fruit' :'banana' ,
  //       'x' : '200',
  //       'y' : '-100'
  //     },
  //     {'fruit' :'cherry' ,
  //       'x' : '200',
  //       'y' : '100'
  //     },
  //     {'fruit' :'blackberry' ,
  //       'x' : '200',
  //       'y' : '300'
  //     },
  //     {'fruit' :'cherry' ,
  //       'x' : '200',
  //       'y' : '500'
  //     },
  //     {'fruit' :'banana' ,
  //       'x' : '200',
  //       'y' : '700'
  //     }],
  //     [{'fruit' :'banana' ,
  //       'x' : '200',
  //       'y' : '-300'
  //     },
  //     {'fruit' :'banana' ,
  //       'x' : '200',
  //       'y' : '-100'
  //     },
  //     {'fruit' :'cherry' ,
  //       'x' : '200',
  //       'y' : '100'
  //     },
  //     {'fruit' :'blackberry' ,
  //       'x' : '200',
  //       'y' : '300'
  //     },
  //     {'fruit' :'cherry' ,
  //       'x' : '200',
  //       'y' : '500'
  //     },
  //     {'fruit' :'banana' ,
  //       'x' : '200',
  //       'y' : '700'
  //     }],
  //     [{'fruit' :'banana' ,
  //       'x' : '200',
  //       'y' : '-300'
  //     },
  //     {'fruit' :'banana' ,
  //       'x' : '200',
  //       'y' : '-100'
  //     },
  //     {'fruit' :'cherry' ,
  //       'x' : '200',
  //       'y' : '100'
  //     },
  //     {'fruit' :'blackberry' ,
  //       'x' : '200',
  //       'y' : '300'
  //     },
  //     {'fruit' :'cherry' ,
  //       'x' : '200',
  //       'y' : '500'
  //     },
  //     {'fruit' :'banana' ,
  //       'x' : '200',
  //       'y' : '700'
  //     }],
  //   ];

  //   let slot_positions = [
  //   {
  //     'x' : '200',
  //     'y' : '300'
  //   },
  //   {
  //     'x' : '400',
  //     'y' : '300'
  //   },
  //   {
  //     'x' : '600',
  //     'y' : '300'
  //   },
  // ]

  let fruits = ['banana', 'banana', 'cherry', 'blackberry', 'cherry', 'banana'];
  var slot1; 
  var slot2; 
  var slot3; 
  let results = [];

    function preload ()
    {
        this.load.setBaseURL('http://localhost/slot_machine_phaser/phaserJs-test-main/');
        

        this.load.image('arrow', 'public/Arrow.png');
        this.load.image('banana', 'public/banana.png');
        this.load.image('blackberry', 'public/blackberry.png');
        this.load.image('cherry', 'public/cherry.png');

        this.load.image('background', 'public/Background.png');
        this.load.image('spin', 'public/spin.png');
        this.load.image('win', 'public/win.png');

        this.load.image('buy', 'public/buy.png');

        insertedCoins = 0;
    }

    function create ()
    {
        slot1 = this.add.image(200, 300, 'blackberry').setScale(0.5);
        slot2 = this.add.image(400, 300, 'banana').setScale(0.5);
        slot3 = this.add.image(600, 300, 'cherry').setScale(0.5);

        this.add.image(400, 300, 'background').setScale(0.5);
        spin_button = this.add.image(400, 500, 'spin').setScale(0.5).setInteractive();

        spin_button.on('pointerover',function(pointer){
          if(!spin_button_clicked){
            spin_button.setScale(0.6);
          }
        })

        spin_button.on('pointerout',function(pointer){
          spin_button.setScale(0.5);
        })

        spin_button.on('pointerdown', function(pointer){
          console.log(insertedCoins);
          console.log(spin_button_clicked);
          if(insertedCoins > 0 && !spin_button_clicked){
            spin_button.setTint(0x808080);
            spin_button.setScale(0.5);
            spin_button_clicked = true;
            UseCoins(insertedCoins);

          }else {
            insertCoinTextFunction("Please insert coin to continue!");
          }
        })

        buyButton = this.add.image(x - 300, y - 250, 'buy');
        buyButton.setScale(0.2);
        buyButton.setInteractive() 
        .on('pointerdown', () => updateCoins(insertedCoins));

        coin = this.add.text(x - 320 ,y - 260, "0");
        coin.setDepth(5); 
        coin.setStyle({
          font: 'bold 30px Arial',
          fill: 'black'
        });
        coin.setFontSize("25px");

        insertCoinText = this.add.text(180 ,430, "");
        insertCoinText.setDepth(5);
        insertCoinText.setStyle({
            font: 'bold 30px Arial',
            fill: 'white'
          });
        insertCoinText.setFontSize("25px");

      //slots
      // let fruits_group_carrousel = this.add.group();
      // let fruit_image_array = [];

      // fruits_carrosel.forEach(element => {
      //   // console.log(element);
      //   element.forEach(element_child => {
      //     fruit_image_array.push(this.add.image(element_child.x, element_child.y, element_child.fruit).setScale(0.5))
      //     // console.log(element_child);
      //   });
      //   // fruits_group_carrousel.create(element.x, element.y, element.fruit).setScale(0.5);
      //   // this.add.image(element.x, element.y, element.fruit).setScale(0.5);
      // });
      // console.log(fruit_image_array);
    }

    var slot1_in = true;
    var slot2_in = true;
    var slot3_in = true;
    function update(){
      if(spin_button_clicked){
        if(slot1_in){
          var randSlot1 =  Math.floor(Math.random() * fruits.length) + 1;
          randSlots(randSlot1, slot1);
          
          setTimeout(function(){
            // randSlots(randSlot1, slot1);
            slot1_in = false; 
            randSlots(randSlot1, slot1);
            results.push(randSlot1);
          }, 1000);
        }

        if(slot1_in == false){
          var randSlot2 =  Math.floor(Math.random() * fruits.length) + 1;
          randSlots(randSlot2, slot2);
          setTimeout(function(){ 
            slot2_in = false;
            randSlots(randSlot2, slot2);
            results.push(randSlot2);
          }, 1000);
        }

        if(slot2_in == false){
          var randSlot3 =  Math.floor(Math.random() * fruits.length) + 1;
          randSlots(randSlot3, slot3);

          setTimeout(function(){ 
            slot3_in = false;
            randSlots(randSlot3, slot3);
            results.push(randSlot3);
            show_results(results);
          }, 1000);

          spin_button_clicked = false;
        }

          
      }
    }

    function randSlots(randSlot , slot){
      console.log(slot);
      switch (randSlot) {
            case 1:
              slot.setTexture('banana');
              console.log('banana');
              // results.push('banana');
              break;
            case 2:
              slot.setTexture('banana');
              console.log('banana');
              // results.push('banana');
              break;
            case 3:
              slot.setTexture('cherry');
              console.log('cherry');
              // results.push('cherry');
              break;
            case 4:
              slot.setTexture('blackberry');
              console.log('blackberry');
              // results.push('blackberry');
              break;
            case 5:
              slot.setTexture('cherry');
              console.log('cherry');
              // results.push('cherry');
              break;
            case 6:
              slot.setTexture('banana');
              console.log('banana');
              // results.push('banana');
              break;
            default:
              break;
          }
    }

    function updateCoins(coins) {
      insertedCoins = coins + 10;
      coin.setText(insertedCoins);
        console.log(insertedCoins);
        insertCoinText.setText("");
    }

    function UseCoins(coins){
      if(spin_button_clicked){
        insertedCoins = coins - 10;
        coin.setText(insertedCoins);
        console.log(insertedCoins);
      }
    }

    function insertCoinTextFunction(text_to_insert){
      insertCoinText.setText(text_to_insert);
    }

    function show_results(){
      console.log(results);
    }
    // function update(time, delta) {
    //   // console.log(time);
    //   if(spin_button_clicked){
    //     this.time.addEvent({ delay: 1000, callback: enable_button(), callbackScope: this, loop: false });
    //   }
    // }

    function enable_button(){
      spin_button_clicked = false;
      console.log(spin_button_clicked);
    }


    //some thoughts to make it run

      // let fruits_group_carrousel = this.add.group();
      // fruits_carrosel.forEach(element => {
      //   console.log(element);
      //   fruits_group_carrousel.create(element.x, element.y, element.fruit).setScale(0.5);
      //   // this.add.image(element.x, element.y, element.fruit).setScale(0.5);
      // });

      // Then select the children of the group, and loop over them.

      // fruits_group_carrousel.children.forEach((element, index) => {
      //   console.log(element);
      // });

      //container test
      // fruits_carrosel.forEach((element, index) => {
        
      //   element = this.add.image(element.x, element.y, element.fruit).setScale(0.5);
      //   console.log(element);
      //     // this.add.image(element.x, element.y, element.fruit).setScale(0.5);
      // });
      // var image0 = this.add.image(200, -300, 'banana').setScale(0.5);
      // var image1 = this.add.image(200, -100, 'banana').setScale(0.5);
      // var image2 = this.add.image(200, 100, 'cherry').setScale(0.5);
      // var image3 = this.add.image(200, 300, 'blackberry').setScale(0.5);
      // var image4 = this.add.image(200, 500, 'cherry').setScale(0.5);
      // var image5 = this.add.image(200, 700, 'banana').setScale(0.5);
      
      // var image00 = this.add.image(200, -300, 'banana').setScale(0.5);
      // var image11 = this.add.image(200, -100, 'banana').setScale(0.5);
      // var image22 = this.add.image(200, 100, 'cherry').setScale(0.5);
      // var image33 = this.add.image(200, 300, 'blackberry').setScale(0.5);
      // var image44 = this.add.image(200, 500, 'cherry').setScale(0.5);
      // var image55 = this.add.image(200, 700, 'banana').setScale(0.5);

      // var image000 = this.add.image(200, -300, 'banana').setScale(0.5);
      // var image111 = this.add.image(200, -100, 'banana').setScale(0.5);
      // var image222 = this.add.image(200, 100, 'cherry').setScale(0.5);
      // var image333 = this.add.image(200, 300, 'blackberry').setScale(0.5);
      // var image444 = this.add.image(200, 500, 'cherry').setScale(0.5);
      // var image555 = this.add.image(200, 700, 'banana').setScale(0.5);

      // var slot1 = this.add.container(0, 0, [ image0, image1, image2, image3, image4, image5 ]);
      // var slot2 = this.add.container(200, 200, [ image00, image11, image22, image33, image44, image55 ]);
      // var slot3 = this.add.container(400, 400, [ image000, image111, image222, image333, image444, image555 ]);

      // slot_positions.forEach((element , index) => {
      //   console.log(element);
      //   this.add.container(element.x, element.y, [ image0, image1, image2, image3, image4, image5 ]);
      // });
    </script>

</body>
</html>

