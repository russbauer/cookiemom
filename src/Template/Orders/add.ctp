
<?php if ($externalView) :?>
  <script>
  $(function() {
    $('nav').remove();
  });
  </script>
<?php else : ?>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><?= $this->Html->link(__('Orders'), ['controller'=>'orders', 'action' => 'index'])?></li>
      <li class="breadcrumb-item active" aria-current="page">Add Cookie</li>
    </ol>
  </nav>
<?php endif; ?>

<h1>Cookie Order Form</h1>
<div id="orderApp" class="cookie form" style="margin-right: 4em;">
  <?= $this->Form->create() ?>
  <?= $this->Form->control("user_id", [ 'type' => 'hidden', 'default' => $user->id]); ?>

  <div style="display: none;">
    <?= $this->Form->control("totalMoney", [ 'v-model' => "totalMoney"]); ?>
    <?= $this->Form->control("totalCookies", [ 'v-model' => "totalCookies"]); ?>
  </div>

  <!-- Traditional in-person orders -->
  <div v-show="step == 1" class="card">
    <div class="card-header bg-primary" id="heading1">
        <h5 class="mb-0 text-white">
            Traditional Orders
        </h5>
    </div> 
    <div class="card-body">
      <table class="table table-striped">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Cookie</th>
            <th scope="col">Quantity</th>
          </tr>
        </thead>
        <tbody>
        <?php 
          $i = 0; 
          foreach ($cookies as $cookie) : ?>
        <tr>
          <th scope="row">
            <?= $cookie->name ?>
            <?= $this->Form->control("order[" . $i . "].cookie_id", [ 'type' => 'hidden', 'default' => $cookie->id]); ?>
            <?= $this->Form->control("order[" . $i . "].cookie_name", [ 'type' => 'hidden', 'default' => $cookie->name]); ?>
          </th>
          <td>
          <?= $this->Form->control("order[" . $i . "].quantity", 
            ['label' => false, 
            'required' => true, 
            'type' => 'number', 
            'v-model' => "orders[{$i}].quantity"]); ?>
          </td>
        </tr>
        <?php 
            $i++; endforeach; ?>
        </tbody>
      </table>
    </div>
    <div class="card-footer">
      <button @click="next" class="btn btn-outline-primary float-right">Continue</button>
    </div>
  </div>

  <!-- Digital orders -->
  <div v-show="step == 2" class="card">
    <div class="card-header bg-info" id="heading2">
        <h5 class="mb-0 text-white">
            Online Orders
        </h5>
    </div>
    <div class="card-body">
    <div>
      <label>Do you have any Digital Cookie 'Girl Delivery' orders?</label>
      <select v-model="hasDigital" :required="step == 2">
        <option></option>
        <option value="false">No</option>
        <option value="true">Yes</option>
        </select>
      </div>
      <div v-show="hasDigital == 'true'">
        <table class="table table-striped">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Cookie</th>
              <th scope="col">Quantity</th>
            </tr>
          </thead>
          <tbody>
          <?php 
            // Keep counting from above
            foreach ($cookies as $cookie) : ?>
          <tr>
            <th scope="row">
              <?= $cookie->name ?>
              <?= $this->Form->control("order[" . $i . "].cookie_id", [ 'type' => 'hidden', 'default' => $cookie->id]); ?>
              <?= $this->Form->control("order[" . $i . "].cookie_name", [ 'type' => 'hidden', 'default' => $cookie->name]); ?>
              <?= $this->Form->control("order[" . $i . "].digital", [ 'type' => 'hidden', 'default' => 1]); ?>
            </th>
            <td>
            <?= $this->Form->control("order[" . $i . "].quantity", [
              'label' => false, 
              ':required' => "hasDigital == 'true'? true : false", 
              'type' => 'number',
              'v-model' => "orders[{$i}].quantity"]); ?>
            </td>
          </tr>
          <?php 
              $i++; endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-footer">
      <button @click="next" class="btn btn-outline-primary float-right">Continue</button>
      <button @click="previous" class="btn btn-outline-primary float-left">Back</button>
    </div>
  </div>

  <!-- Summary -->
  <div class="card" v-show="step == 3">
    <div class="card-header bg-info" id="heading3">
        <h5 class="mb-0 text-white">
            Summary
        </h5>
    </div>
    <div class="card-body">
      You have entered a total of {{totalCookies}} boxes.  This totals <b>${{totalMoney}}</b> 
      that you must collect and return to the troop.  Payment is due by March 31st 2019.
      <br/><br/>
      <div class="alert alert-danger" role="alert">
        Once you take receipt of the cookies, they cannot be returned to the troop.  You must sell all the cookies you have ordered.
      </div>
    </div>
    <div class="card-footer">
      <button class="btn btn-outline-primary float-right">Agree and Complete</button>
      <button @click="previous" class="btn btn-outline-primary float-left">Back</button>
    </div>
  </div>

<?= $this->Form->end() ?>
</div>

<script>
var orderApp = new Vue({
  el: '#orderApp',
  methods: {
    next: function(event) {
      this.calculateTotal();
      var valid = $('#orderApp form')[0].checkValidity();
      if (valid) {
        event.preventDefault();
        this.step++;
        console.log("Valid");
      } else {
        console.log("Not Valid");
      }
    },
    previous: function(event) {
      event.preventDefault();
      this.step--;
    },
    calculateTotal: function() {
      this.totalCookies = 0;
      for (var k in this.orders) {
        if (this.orders[k].quantity) {
          this.totalCookies += parseInt(this.orders[k].quantity);
        }
      }
      this.totalMoney = this.totalCookies * 5.00;
    }
  },
  data: {
    step: 1,
    hasDigital: "",
    orders: [],
    totalCookies: 0,
    totalMoney: 0
  },
  created: function () {
    for (var i = 0; i < 20; i++) {
      this.orders.push({id: ""});
    }
  }
});
</script>