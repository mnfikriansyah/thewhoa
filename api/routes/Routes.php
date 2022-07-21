<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\App;

require_once 'vendor/autoload.php';

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        return $response;
    });

    $app->post('/antiqueitem', function (Request $request, Response $response, array $args) {
        $data = $request->getParsedBody();
        $item_id = $data["item_id"];
        $itemdesc = $data["itemdesc"];
        $category = $data["category"];
        $startprice = $data["startprice"];

        if ($item_id == null || $item_id == "") {
            $data = array(
                'error' => 'true',
                'message' => 'item_id is required'
            );
        } elseif ($itemdesc == null || $itemdesc == "") {
            $data = array(
                'error' => 'true',
                'message' => 'itemdesc is required'
            );
        } elseif ($category == null || $category == "") {
            $data = array(
                'error' => 'true',
                'message' => 'category is required'
            );
        } elseif ($startprice == null || $startprice == "") {
            $data = array(
                'error' => 'true',
                'message' => 'startprice is required'
            );
        } else {
            try {

                $sql = "INSERT INTO antiqueitem (item_id, itemdesc, category, startprice) VALUES (:item_id, :itemdesc, :category, :startprice)";

                $db = new Db();
                $conn = $db->connect();

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':item_id', $item_id);
                $stmt->bindParam(':itemdesc', $itemdesc);
                $stmt->bindParam(':category', $category);
                $stmt->bindParam(':startprice', $startprice);
                $stmt->execute();

                $result = array(
                    'error' => 'false',
                    'message' => 'Successfully add antique item',
                );

                $db = null;
                $response->getBody()->write(json_encode($result));
                return $response
                    ->withHeader('content-type', 'application/json')
                    ->withStatus(200);
            } catch (PDOException $e) {
                $data = array(
                    'error' => 'true',
                    'message' => $e->getMessage()
                );
            }
        }

        $response->getBody()->write(json_encode($data));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    });

    $app->get('/antiqueitems', function ($request, $response) {
        $sql = "SELECT * FROM antiqueitem";

        try {
            $db = new Db();
            $conn = $db->connect();
            $stmt = $conn->query($sql);
            $contacts = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;

            $result = array(
                'error' => 'false',
                'message' => 'Antique items fetched successfully',
                'data' => $contacts
            );

            $response->getBody()->write(json_encode($result));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
        } catch (PDOException $e) {
            $data = array(
                'error' => 'true',
                'message' => $e->getMessage()
            );

            $response->getBody()->write(json_encode($data));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
    });

    $app->get('/bids', function ($request, $response) {
        $sql = "SELECT * FROM biditem";

        try {
            $db = new Db();
            $conn = $db->connect();
            $stmt = $conn->query($sql);
            $contacts = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;

            $result = array(
                'error' => 'false',
                'message' => 'Bid fetched successfully',
                'data' => $contacts
            );

            $response->getBody()->write(json_encode($result));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
        } catch (PDOException $e) {
            $data = array(
                'error' => 'true',
                'message' => $e->getMessage()
            );

            $response->getBody()->write(json_encode($data));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
    });

    $app->get('/bid/{bidder_id}', function (Request $request, Response $response) {
        $bidder_id = $request->getAttribute('bidder_id');

        if ($bidder_id == null || $bidder_id == "") {
            $data = array(
                'error' => 'true',
                'message' => 'Bidder id is required'
            );
        } else {
            $sql = "SELECT * FROM biditem WHERE bidder_id=:bidder_id";

            try {
                $db = new Db();
                $conn = $db->connect();
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':bidder_id', $bidder_id);
                $stmt->execute();
                $contact = $stmt->fetch(PDO::FETCH_OBJ);
                $db = null;

                if ($contact == null || $contact == "") {
                    $data = array(
                        'error' => 'true',
                        'message' => 'Bid not found'
                    );
                } else {
                    $result = array(
                        'error' => 'false',
                        'message' => 'Bid fetched successfully',
                        'data' => $contact
                    );

                    $response->getBody()->write(json_encode($result));
                    return $response
                        ->withHeader('content-type', 'application/json')
                        ->withStatus(200);
                }
            } catch (PDOException $e) {
                $data = array(
                    'error' => 'true',
                    'message' => $e->getMessage()
                );
            }
        }

        $response->getBody()->write(json_encode($data));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    });

    $app->post('/bid', function (Request $request, Response $response, array $args) {
        $data = $request->getParsedBody();
        $bidder_id = $data['bidder_id'];
        $biddername = $data['biddername'];
        $contact = $data['contact'];
        $bidprice = $data['bidprice'];
        $item_id = $data["item_id"];
        $itemdesc = $data["itemdesc"];
        $category = $data["category"];
        $startprice = $data["startprice"];

        if ($item_id == null || $item_id == "") {
            $data = array(
                'error' => 'true',
                'message' => 'item_id is required'
            );
        } elseif ($itemdesc == null || $itemdesc == "") {
            $data = array(
                'error' => 'true',
                'message' => 'description is required'
            );
        } elseif ($category == null || $category == "") {
            $data = array(
                'error' => 'true',
                'message' => 'category is required'
            );
        } elseif ($startprice == null || $startprice == "") {
            $data = array(
                'error' => 'true',
                'message' => 'startprice is required'
            );
        } elseif ($bidder_id == null || $bidder_id == "") {
            $data = array(
                'error' => 'true',
                'message' => 'bidder_id is required'
            );
        } elseif ($biddername == null || $biddername == "") {
            $data = array(
                'error' => 'true',
                'message' => 'biddername is required'
            );
        } elseif ($contact == null || $contact == "") {
            $data = array(
                'error' => 'true',
                'message' => 'contactnum is required'
            );
        } elseif ($bidprice == null || $bidprice == "") {
            $data = array(
                'error' => 'true',
                'message' => 'bidprice is required'
            );
        } else {
            $sql = "INSERT INTO biditem (item_id, itemdesc, category, startprice, bidder_id, biddername, contact, bidprice) VALUES (:item_id, :itemdesc, :category, :startprice, :bidder_id, :biddername, :contact, :bidprice)";

            try {
                $db = new Db();
                $conn = $db->connect();
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':item_id', $item_id);
                $stmt->bindParam(':itemdesc', $itemdesc);
                $stmt->bindParam(':category', $category);
                $stmt->bindParam(':startprice', $startprice);
                $stmt->bindParam(':bidder_id', $bidder_id);
                $stmt->bindParam(':biddername', $biddername);
                $stmt->bindParam(':contact', $contact);
                $stmt->bindParam(':bidprice', $bidprice);
                $stmt->execute();
                $db = null;

                $data = array(
                    'error' => 'false',
                    'message' => 'Bid added successfully'
                );

                $response->getBody()->write(json_encode($data));
                return $response
                    ->withHeader('content-type', 'application/json')
                    ->withStatus(200);
            } catch (PDOException $e) {
                $data = array(
                    'error' => 'true',
                    'message' => $e->getMessage()
                );
            }
        }

        $response->getBody()->write(json_encode($data));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    });

    $app->put('/bid/{bidder_id}', function (Request $request, Response $response, array $args) {
        $data = $request->getParsedBody();
        $bidder_id = $request->getAttribute('bidder_id');
        $biddername = $data['biddername'];
        $contact = $data['contactnum'];
        $bidprice = $data['bidprice'];
        $item_id = $data["item_id"];
        $itemdesc = $data["itemdesc"];
        $category = $data["category"];
        $startprice = $data["startprice"];

        if ($item_id == null || $item_id == "") {
            $data = array(
                'error' => 'true',
                'message' => 'item_id is required'
            );
        } elseif ($itemdesc == null || $itemdesc == "") {
            $data = array(
                'error' => 'true',
                'message' => 'itemdescription is required'
            );
        } elseif ($category == null || $category == "") {
            $data = array(
                'error' => 'true',
                'message' => 'category is required'
            );
        } elseif ($startprice == null || $startprice == "") {
            $data = array(
                'error' => 'true',
                'message' => 'startprice is required'
            );
        } elseif ($bidder_id == null || $bidder_id == "") {
            $data = array(
                'error' => 'true',
                'message' => 'bidder_id is required'
            );
        } elseif ($biddername == null || $biddername == "") {
            $data = array(
                'error' => 'true',
                'message' => 'biddername is required'
            );
        } elseif ($contact == null || $contact == "") {
            $data = array(
                'error' => 'true',
                'message' => 'contact is required'
            );
        } elseif ($bidprice == null || $bidprice == "") {
            $data = array(
                'error' => 'true',
                'message' => 'bid is required'
            );
        } else {
            $sql = "SELECT * FROM biditem WHERE bidder_id = :bidder_id";
            $getDb = new Db();
            $conn = $getDb->connect();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':bidder_id', $bidder_id);
            $stmt->execute();
            $rowCount = $stmt->rowCount();
            $getDb = null;

            if ($rowCount == 0) {
                $data = array(
                    'error' => 'false',
                    'message' => 'Bidder id not found'
                );
            } else {

                $sql = "UPDATE biditem SET biddername = :biddername, contact = :contact, bidprice = :bidprice, item_id = :item_id, itemdescription = :itemdesc, category = :category, startprice = :startprice WHERE bidder_id = :bidder_id";

                try {
                    $db = new Db();
                    $conn = $db->connect();
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':item_id', $item_id);
                    $stmt->bindParam(':itemdesc', $itemdesc);
                    $stmt->bindParam(':category', $category);
                    $stmt->bindParam(':startprice', $startprice);
                    $stmt->bindParam(':bidder_id', $bidder_id);
                    $stmt->bindParam(':biddername', $biddername);
                    $stmt->bindParam(':contact', $contact);
                    $stmt->bindParam(':bidprice', $bidprice);
                    $stmt->execute();
                    $db = null;

                    $data = array(
                        'error' => 'false',
                        'message' => 'Bid updated successfully'
                    );

                    $response->getBody()->write(json_encode($data));
                    return $response
                        ->withHeader('content-type', 'application/json')
                        ->withStatus(200);
                } catch (PDOException $e) {
                    $data = array(
                        'error' => 'true',
                        'message' => $e->getMessage()
                    );
                }
            }
        }

        $response->getBody()->write(json_encode($data));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    });

    $app->delete(
        '/bid/{bidder_id}',
        function (Request $request, Response $response) {
            $id = $request->getAttribute('bidder_id');

            if ($id == null || $id == "") {
                $data = array(
                    'error' => 'true',
                    'message' => 'Bidder_id is required'
                );
            } else {
                $sql = "SELECT * FROM biditem WHERE bidder_id = :bidder_id";
                $getDb = new Db();
                $conn = $getDb->connect();
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':bidder_id', $id);
                $stmt->execute();
                $rowCount = $stmt->rowCount();
                $getDb = null;

                if ($rowCount == 0) {
                    $data = array(
                        'error' => 'false',
                        'message' => 'Bidder id not found'
                    );
                } else {
                    $sql = "DELETE FROM biditem WHERE bidder_id=:id";

                    try {
                        $db = new Db();
                        $conn = $db->connect();
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':id', $id);
                        $stmt->execute();
                        $db = null;

                        $data = array(
                            'error' => 'false',
                            'message' => 'Bid deleted successfully'
                        );

                        $db = null;
                        $response->getBody()->write(json_encode($data));
                        return $response
                            ->withHeader('content-type', 'application/json')
                            ->withStatus(200);
                    } catch (PDOException $e) {
                        $data = array(
                            'error' => 'true',
                            'message' => $e->getMessage()
                        );
                    }
                }
            }

            $response->getBody()->write(json_encode($data));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
    );
};
