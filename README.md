# To set up for testing locally

Initial data needs to be seeded into the database for user, shopping_list, shopping_list_items and products.

##user:
INSERT INTO `homestead`.`users` (`id`, `name`, `email`, `password`) VALUES ('1', 'test', 'test@email.com', 'password');

##products:
INSERT INTO `homestead`.`products` (`id`, `price`, `name`) VALUES ('1', '0.60', 'item');
INSERT INTO `homestead`.`products` (`id`, `price`, `name`) VALUES ('2', '1.20', 'item2');


##shopping_list
INSERT INTO `homestead`.`shopping_lists` (`id`, `user_id`, `budget`) VALUES ('1', '1', '50.00');


##shopping_list_items
INSERT INTO `homestead`.`shopping_list_items` (`list_id`, `product_id`, `is_purchased`, `weight_on_list`) VALUES ('1', '1', '0', '0');
INSERT INTO `homestead`.`shopping_list_items` (`list_id`, `product_id`, `is_purchased`, `weight_on_list`) VALUES ('1', '2', '0', '0');


