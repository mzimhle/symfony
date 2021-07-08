<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
// Datatables
use Omines\DataTablesBundle\Adapter\ArrayAdapter;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;
// Entity
use App\Entity\Member;
// Query
use Doctrine\ORM\QueryBuilder;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, DataTableFactory $dataTableFactory): Response
    {
        $table = $dataTableFactory->create()
            ->add('name', TextColumn::class, ['label' => 'Name'])
            ->add('surname', TextColumn::class, ['label' => 'Surname'])
            ->add('cellphone', TextColumn::class, ['label' => 'Cellphone Number'])
            ->add('email', TextColumn::class, ['label' => 'Email Address'])
			->createAdapter(ORMAdapter::class, [
				'entity' => Member::class,
				'query' => function (QueryBuilder $builder) {
					$builder->select('m')
					->from('App\Entity\Member', 'm');
				}
			])
            ->handleRequest($request);

        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('home/index.html.twig', ['datatable' => $table]);
    }
}
