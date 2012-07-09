<?php

/**
 * Sample form to demonstrate styles. OK to remove or use as a template
 */
class Application_Form_Sample extends Zend_Form
{

    public function init()
    {

        //If you would like to attach seperate css/js to your form,
        //do it like this.
        //Not sure about this though, to save http requests, i've been
        //tryign to combine/minify scripts and css
        //$view=$this->getView();
        //$view->headScript()->appendFile("/js/applicationForm.js");
        //$view->headLink()->appendStylesheet("/css/updateForm.css");

        $this->setAttrib("id","sampleForm");

        $firstName=new Zend_Form_Element_Text("firstName");
        $firstName->setLabel("First Name: ")->setDecorators(array("ViewHelper","Label",array("HtmlTag",array("tag"=>"br","openOnly"=>true))));
        $this->addElement($firstName);

        $lastName=new Zend_Form_Element_Text("lastName");
        $lastName->setLabel("Last Name: ")->setDecorators(array("ViewHelper","Label",array("HtmlTag",array("tag"=>"br","openOnly"=>true))));
        $this->addElement($lastName);

        $title=new Zend_Form_Element_Text("title");
        $title->setLabel("Title: ")->setDecorators(array("ViewHelper","Label",array("HtmlTag",array("tag"=>"br","openOnly"=>true))));
        $this->addElement($title);

        $department=new Zend_Form_Element_Text("department");
        $department->setLabel("Department: ")->setDecorators(array("ViewHelper","Label",array("HtmlTag",array("tag"=>"br","openOnly"=>true))));
        $this->addElement($department);

        $title2=new Zend_Form_Element_Text("title2");
        $title2->setLabel("Title: ")->setDecorators(array("ViewHelper","Label",array("HtmlTag",array("tag"=>"br","openOnly"=>true))));
        //$this->addElement($title2);

        $department2=new Zend_Form_Element_Text("department2");
        $department2->setLabel("Working Department2: ")->setDecorators(array("ViewHelper","Label",array("HtmlTag",array("tag"=>"br","openOnly"=>true))));
        //$this->addElement($department2);

        $phone=new Zend_Form_Element_Text("phone");
        $phone->setLabel("Telephone: ")->setDecorators(array("ViewHelper","Label",array("HtmlTag",array("tag"=>"br","openOnly"=>true))));
        $this->addElement($phone);

        $fax=new Zend_Form_Element_Text("fax");
        $fax->setLabel("Fax: ")->setDecorators(array("ViewHelper","Label",array("HtmlTag",array("tag"=>"br","openOnly"=>true))));
        $this->addElement($fax);

        $mobile=new Zend_Form_Element_Text("mobile");
        $mobile->setLabel("Mobile: ")->setDecorators(array("ViewHelper","Label",array("HtmlTag",array("tag"=>"br","openOnly"=>true))));
        $this->addElement($mobile);

        $location=new Zend_Form_Element_Text("location");
        $location->setLabel("Location: ")->setDecorators(array("ViewHelper","Label",array("HtmlTag",array("tag"=>"br","openOnly"=>true))));
        $this->addElement($location);

        $mso=new Zend_Form_Element_Select("mso");
        $mso->setMultiOptions($this->getMSO())
                ->setLabel("MSO:")
                ->setDecorators(array("ViewHelper","Label",array("HtmlTag",array("tag"=>"br","openOnly"=>true))));
        $this->addElement($mso);

        $comments=new Zend_Form_Element_Textarea("comments");
        $comments->setLabel("Comments:")->setDecorators(array("ViewHelper","Label",array("HtmlTag",array("tag"=>"br","openOnly"=>true))));
        $this->addElement($comments);

        $submit=new Zend_Form_Element_Submit("submit");
        $submit->setLabel("Send Update")->setAttrib("class", "button");
        $this->addElement($submit);

    }

    private function getMSO(){
        $options=array(
            "na"=>"Don't know or select one...",

        );
        return $options;
    }


}

