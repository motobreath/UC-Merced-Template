<?php

class Application_Form_AdminUsers extends Zend_Form
{

    public function init()
    {
        $this->setDecorators(array(
            'FormElements',
            'Form',
            array('FormErrors', array('placement' => 'prepend',"onlyCustomFormErrors"=>true))
         ));

        $this->setAttrib("id","addAdmin");

        $check=new App_Validate_IsAdministrator();

        $nameBox=new Zend_Form_Element_Text("ucmnetid");
        $nameBox->setRequired()
                ->addValidator('NotEmpty', true, array('messages' => 'Please enter a ucmnetID'))
                ->addValidator($check)
                ->setDecorators(array("Label",array("Errors",array("placement"=>"prepend")),"ViewHelper"))
                ->setAttribs(array(
                    "placeholder"=>"Enter UCMNETID",
                    "class"=>"adminAdd"
                ));

        $submit=new Zend_Form_Element_Submit("Go");
        $submit->setLabel("Go")
            ->setAttrib("class","button")
            ->setDecorators(array("ViewHelper"));

        $this->addElements(array($nameBox,$submit));

    }


}

