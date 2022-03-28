<?
use \Bitrix\Main\Localization\Loc,
    \Bitrix\Main\Application,
    \Bitrix\Main\Context,
    \Bitrix\Main\Loader,
    \Bitrix\Main\ModuleManager;

Loc::loadMessages(__FILE__);

if (class_exists('ibs_shopnotebook')) return;

Class ibs_shopnotebook extends CModule
{
    public $DOCUMENT_ROOT = "";
    public $BASE_DIR = "";
    public $MODULE_PATH = "";
    public $MODULE_ID = "ibs.shopnotebook";
    public $COMPONENT_ID = "ibs.shopnotebook";
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $MODULE_CSS;
    public $PARTNER_NAME;
    public $PARTNER_URI;

    public function __construct()
    {
        $arModuleVersion = array();
        $this->DOCUMENT_ROOT = Application::getDocumentRoot();
        $this->MODULE_PATH = str_replace("\\", "/", realpath(__DIR__ . '/..'));
        $this->BASE_DIR = strpos($this->MODULE_PATH, '/local/modules/') ? 'local' : 'bitrix';
        include("{$this->MODULE_PATH}/install/version.php");

        if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion))
        {
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        }

        $this->MODULE_NAME = Loc::getMessage('IBS_SHOP_NOTEBOOK_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('IBS_SHOP_NOTEBOOK_MODULE_DESCRIPTION',['#MODULE_NAME#'=>$this->MODULE_ID]);
        $this->PARTNER_NAME = Loc::getMessage('IBS_SHOP_NOTEBOOK_PARTNER_NAME');
        $this->PARTNER_URI = Loc::getMessage('IBS_SHOP_NOTEBOOK_PARTNER_URL');
    }

    public function getClassesTable()
    {
        $moduleLibDir = $this->MODULE_PATH.'/lib';
        $moduleLibNameSpace = '\Ibs\ShopNotebook\\';
        $directory = new \RecursiveDirectoryIterator($moduleLibDir);
        $iterator = new \RecursiveIteratorIterator($directory);
        $classList = [];

        foreach ($iterator as $entry)
        {
            if ($entry->isFile() && $entry->getExtension() === 'php')
            {
                if(strpos($entry->getBasename('.php'), 'table') !== false) {
                    $classList[$moduleLibNameSpace.$entry->getBasename('.php')] = "/{$this->BASE_DIR}/modules/{$this->MODULE_ID}/lib/{$entry->getBasename()}";
                }
            }
        }
        Loader::registerAutoloadClasses(null, $classList);
        return $classList;
    }

    public function InstallFiles()
    {
        CopyDirFiles("{$this->MODULE_PATH}/install/components", $this->DOCUMENT_ROOT."/{$this->BASE_DIR}/components", true, true);
        CopyDirFiles("{$this->MODULE_PATH}/install/css", $this->DOCUMENT_ROOT."/bitrix/css/{$this->MODULE_ID}", true, true);
        CopyDirFiles("{$this->MODULE_PATH}/install/js", $this->DOCUMENT_ROOT."/bitrix/js/{$this->MODULE_ID}", true, true);
        return true;
    }

    public function UnInstallFiles()
    {
        DeleteDirFilesEx($this->DOCUMENT_ROOT."/{$this->BASE_DIR}/components/ibs");
        DeleteDirFilesEx($this->DOCUMENT_ROOT."/bitrix/css/{$this->MODULE_ID}");
        DeleteDirFilesEx($this->DOCUMENT_ROOT."/bitrix/js/{$this->MODULE_ID}");
        return true;
    }

    function installDB()
    {
        $classList = $this->getClassesTable();
        foreach (array_flip($classList) as $className){
            $entity = $className::getEntity();
            $connection = $entity->getConnection();
            $tableName = $entity->getDBTableName();
            if (!$connection->isTableExists($tableName)) $entity->createDbTable();
        }
//        $DB->runSQLBatch($this->DOCUMENT_ROOT . "/{$this->BASE_DIR}/modules/{$this->MODULE_ID}/install/db/" . mb_strtolower($DB->type) . '/install.sql');
    }

    function UnInstallDB()
    {
        $classList = $this->getClassesTable();
        foreach (array_flip($classList) as $className)
        {
            $entity = $className::getEntity();
            $connection = $entity->getConnection();
            $tableName = $entity->getDBTableName();
            if ($connection->isTableExists($tableName)) $connection->dropTable($tableName);
        }
//        $DB->runSQLBatch($this->DOCUMENT_ROOT . "/{$this->BASE_DIR}/modules/{$this->MODULE_ID}/install/db/" . mb_strtolower($DB->type) . '/uninstall.sql');
    }

    function InstallEvents()
    {
        return true;
    }

    function UnInstallEvents()
    {
        return true;
    }

    public function DoInstall()
    {
        global $APPLICATION, $step, $DB, $errors;
        $request = Context::getCurrent()->getRequest();
        $step = intval($step);
        if($step<2)
        {
            $APPLICATION->IncludeAdminFile(Loc::getMessage('IBS_SHOP_NOTEBOOK_INSTALL_MODULE_STEP_1'), "{$this->MODULE_PATH}/install/step1.php");
        }else{
            if($request["deldata"] == "Y") {
                $this->UnInstallDB();
                $this->installDB();
            }else{
                $this->installDB();
            }
            $this->InstallFiles();
            ModuleManager::registerModule($this->MODULE_ID);
            $APPLICATION->IncludeAdminFile(Loc::getMessage('IBS_SHOP_NOTEBOOK_INSTALL_MODULE_STEP_2'), "{$this->MODULE_PATH}/install/step2.php");
        }

    }

    public function DoUninstall()
    {
        global $APPLICATION, $step, $errors;
        $request = Context::getCurrent()->getRequest();
        $FORM_RIGHT = $APPLICATION->GetGroupRight("form");
        if ($FORM_RIGHT>="W")
        {
            $step = intval($step);
            if($step<2)
            {
                $APPLICATION->IncludeAdminFile(Loc::getMessage('IBS_SHOP_NOTEBOOK_UNINSTALL_MODULE'), "{$this->MODULE_PATH}/install/unstep1.php");
            }
            elseif($step == 2)
            {
                $errors = false;

                if($request["savedata"] != "Y") {
                    $this->UnInstallDB();
                }

                $this->UnInstallFiles();
                ModuleManager::unRegisterModule($this->MODULE_ID);

                $APPLICATION->IncludeAdminFile(Loc::getMessage("IBS_SHOP_NOTEBOOK_UNINSTALL_MODULE"), "{$this->MODULE_PATH}/install/unstep2.php");
            }
        }


    }
}
?>